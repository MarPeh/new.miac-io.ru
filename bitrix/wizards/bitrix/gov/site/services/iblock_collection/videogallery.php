<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock"))
	return;

$dir = __DIR__.'/lang/'.LANGUAGE_ID.'/';
if (file_exists($dir.'_iblockDataSelect.php')) {
	require ('lang/'.LANGUAGE_ID.'/_iblockDataSelect.php');
} else {
	require ('lang/'.LANGUAGE_ID.'/_iblockdataselect.php');
}

$iblockCode = "videogallery_".WIZARD_SITE_ID;
$iblockType = "photovideogallery"; 
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
	$iblockID = $arIBlock["ID"]; 

if ($iblockID)
{
	$arProperties = Array("FILE", "DURATION");
	foreach ($arProperties as $propertyName)
	{
		${$propertyName."_PROPERTY_ID"} = 0;
		$properties = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID, "CODE" => $propertyName));
		if ($arProperty = $properties->Fetch())
			${$propertyName."_PROPERTY_ID"} = $arProperty["ID"];
	}	
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", array("VIDEOGALLERY_IBLOCK_ID" => $iblockID, "VIDEOGALLERY_PFILE_ID" => $FILE_PROPERTY_ID, "VIDEOGALLERY_PDURATION_ID" => $DURATION_PROPERTY_ID, "VIDEOGALLERY_SECTION_ID" => $arIntroSection["ID"], "VIDEOGALLERY_ELEMENT_ID" => $arIntro["ID"]));
}

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH.'/xml/'.LANGUAGE_ID.'/videogallery/videogallery_'.$suffix.'.xml'; 

$iblockID = WizardServices::ImportIBlockFromXML(
	$iblockXMLFile, 
	"gossite_videogallery",
	$iblockType, 
	WIZARD_SITE_ID, 
	$permissions = Array(
		"1" => "X",
		"2" => "R",
		WIZARD_PORTAL_ADMINISTRATION_GROUP => "X",
	)
);

if ($iblockID < 1)
	return;

$arProperties = Array("FILE", "DURATION");
foreach ($arProperties as $propertyName)
{
	${$propertyName."_PROPERTY_ID"} = 0;
	$properties = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID, "CODE" => $propertyName));
	if ($arProperty = $properties->Fetch())
		${$propertyName."_PROPERTY_ID"} = $arProperty["ID"];
}	

$intro = CIBlockElement::GetList(Array("ID"=>"DESC"), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID), false, false, Array("ID", "IBLOCK_SECTION_ID"));
$arIntro = $intro->Fetch();

$introSection = CIBlockSection::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID, "NAME" => GetMessage('iblock_vg_main_page')));
$arIntroSection = $introSection->Fetch();
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/videogallery/index.php", array("VIDEOGALLERY_IBLOCK_ID" => $iblockID, "VIDEOGALLERY_PFILE_ID" => $FILE_PROPERTY_ID, "VIDEOGALLERY_PDURATION_ID" => $DURATION_PROPERTY_ID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."feedback/law-map/wcag/level_a/index.php", array("VIDEOGALLERY_PATH" => substr($path,1)));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", array("VIDEOGALLERY_IBLOCK_ID" => $iblockID, "VIDEOGALLERY_PFILE_ID" => $FILE_PROPERTY_ID, "VIDEOGALLERY_PDURATION_ID" => $DURATION_PROPERTY_ID, "VIDEOGALLERY_SECTION_ID" => $arIntroSection["ID"], "VIDEOGALLERY_ELEMENT_ID" => $arIntro["ID"]));

$intro = CIBlockElement::GetList(Array("ID"=>"DESC"), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID), false, false, Array("ID", 'PROPERTY_'.$FILE_PROPERTY_ID));
$el = new CIBlockElement();
while($arIntro = $intro->Fetch()) {
	$el->SetPropertyValues(
		$arIntro["ID"],
		$iblockID,
		array('FILE'=>array('VALUE'=>WIZARD_SITE_DIR.$arIntro['PROPERTY_'.$FILE_PROPERTY_ID.'_VALUE'])),
		'FILE'
	);

}

?>