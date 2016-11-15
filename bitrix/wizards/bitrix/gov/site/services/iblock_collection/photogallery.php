<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule('iblock'))
	return;

$dir = __DIR__.'/lang/'.LANGUAGE_ID.'/';
if (file_exists($dir.'_iblockDataSelect.php')) {
	require ('lang/'.LANGUAGE_ID.'/_iblockDataSelect.php');
} else {
	require ('lang/'.LANGUAGE_ID.'/_iblockdataselect.php');
}

$iblockCode = "photogallery_".WIZARD_SITE_ID;
$iblockType = 'photovideogallery'; 
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
	$iblockID = $arIBlock["ID"]; 

if ($iblockID)
{
	$ignoredSection='';
	$sectionList = CIBlockSection::GetList(Array(), array('CODE'=>'region_foto'));
	if($arSection = $sectionList->GetNext())
		$ignoredSection=$arSection['ID'];

		
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/_index.php', array('PHOTOGALLERY_IBLOCK_ID' => $iblockID));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/_index.php', array('IGNORE_SECTION_ID' => $ignoredSection));
	
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/index_contrast.php', array('PHOTOGALLERY_IBLOCK_ID' => $iblockID));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/index_contrast.php', array('IGNORE_SECTION_ID' => $ignoredSection));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/index_mobile.php', array('PHOTOGALLERY_IBLOCK_ID' => $iblockID));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/index_mobile.php', array('IGNORE_SECTION_ID' => $ignoredSection));
	return;
}

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH.'/xml/'.LANGUAGE_ID.'/photogallery/photogallery_'.$suffix.'.xml'; 
	
$iblockID = WizardServices::ImportIBlockFromXML(
	$iblockXMLFile, 
	"gossite_photogallery",
	$iblockType, 
	WIZARD_SITE_ID, 
	$permissions = Array(
		'1' => 'X',
		'2' => 'R',
		WIZARD_PORTAL_ADMINISTRATION_GROUP => 'X',
	)
);

if ($iblockID < 1)
	return;

$arProperties = Array("REAL_PICTURE","PUBLIC_ELEMENT","APPROVE_ELEMENT",);
$arrPropID=array();
foreach ($arProperties as $propertyName)
{
    $arrPropID[$propertyName] = 0;
    $properties = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID, "CODE" => $propertyName));
    if ($arProperty = $properties->Fetch())
        $arrPropID[$propertyName] = $arProperty["ID"];
}

WizardServices::SetIBlockFormSettings($iblockID, Array ( 'tabs' => 'edit1--#--'.GetMessage('iblock_photogallery_edit1').'--,--ACTIVE--#--'.GetMessage('iblock_photogallery_ACTIVE').'--,--ACTIVE_FROM--#--'.GetMessage('iblock_photogallery_ACTIVE_FROM').'--,--ACTIVE_TO--#--'.GetMessage('iblock_photogallery_ACTIVE_TO').'--,--NAME--#--*'.GetMessage('iblock_photogallery_NAME').'--,--DETAIL_PICTURE--#--'.GetMessage('iblock_photogallery_DETAIL_PICTURE').'--;--edit3--#--'.GetMessage('iblock_photogallery_edit3').'--,--SECTIONS--#--'.GetMessage('iblock_photogallery_SECTIONS').'--,--PREVIEW_PICTURE--#--'.GetMessage('iblock_photogallery_PREVIEW_PICTURE').'--,--PROPERTY_'.$arrPropID['REAL_PICTURE'].'--#--'.GetMessage('iblock_photogallery_REAL_PICTURE').'--,--PREVIEW_TEXT--#--'.GetMessage('iblock_photogallery_PREVIEW_TEXT').'--,--DETAIL_TEXT--#--'.GetMessage('iblock_photogallery_DETAIL_TEXT').'--;--', ));


$ignoredSection='';
$sectionList = CIBlockSection::GetList(Array(), array('CODE'=>'region_foto'));
if($arSection = $sectionList->GetNext())
	$ignoredSection=$arSection['ID'];

$list = CIBlockElement::GetList(Array(), array('IBLOCK_ID'=>$iblockID));
$el = new CIBlockElement;
while ($element = $list->GetNext()){
	$rand = rand(0,10);
	$el->Update($element['ID'],array('ACTIVE_FROM'=>date('d.m.Y',strtotime('-'.$rand.' day'))));
}

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/_index.php', array('PHOTOGALLERY_IBLOCK_ID' => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/_index.php', array('IGNORE_SECTION_ID' => $ignoredSection));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/content/photo/index.php', array('PHOTOGALLERY_IBLOCK_ID' => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/content/gallery/index.php', array('PHOTOGALLERY_IBLOCK_ID' => $iblockID));

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/index_contrast.php', array('PHOTOGALLERY_IBLOCK_ID' => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/index_contrast.php', array('IGNORE_SECTION_ID' => $ignoredSection));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/index_mobile.php', array('PHOTOGALLERY_IBLOCK_ID' => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/index_mobile.php', array('IGNORE_SECTION_ID' => $ignoredSection));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path.'/photogallery/index.php', array('PHOTOGALLERY_IBLOCK_ID' => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path.'/photogallery/rss.php', array('PHOTOGALLERY_IBLOCK_ID' => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/bitrix/gadgets/gosportal/gallery/lang/ru/exec/index.php', array('PHOTOGALLERY_IBLOCK_ID' => $iblockID, 'LINK_PATH' => $path));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."about-bitrix/journal_of_operations.php", array("PHOTOGALLERY_IBLOCK_ID" => $iblockID));

?>