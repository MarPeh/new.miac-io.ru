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

if (!in_array($suffix, array('mo','gd','po','zso')))
	return;

$iblockCode = "GID_routes_types_".WIZARD_SITE_ID;
$iblockType = "information"; 
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    return;
}

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/gid_routes/gid_routes_types.xml";

$iblockID = WizardServices::ImportIBlockFromXML(
	$iblockXMLFile, 
	"gossite_GID_routes_types",
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

//IBlock fields
$iblock = new CIBlock;
$arFields = Array(
    "ACTIVE" => "Y",
    "CODE" => $iblockCode,
	"LIST_PAGE_URL" => $path."/turizm/routes.php",
	"SECTION_PAGE_URL" => $path."/turizm/routes.php",
	"DETAIL_PAGE_URL" => $path."/turizm/detail_routes.php?ID=#ELEMENT_ID#",
    "XML_ID" => $iblockCode,
    // "NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME"),
);
$iblock->Update($iblockID, $arFields);

$arProperties = Array();
$arrPropID=array();
foreach ($arProperties as $propertyName)
{
	$arrPropID[$propertyName] = 0;
	$properties = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID, "CODE" => $propertyName));
	if ($arProperty = $properties->Fetch())
		$arrPropID[$propertyName] = $arProperty["ID"];
}


WizardServices::SetIBlockFormSettings($iblockID, Array ( 'tabs' => 'edit1--#--'.GetMessage('iblock_routes_type_edit1').'--,--ACTIVE--#--'.GetMessage('iblock_routes_type_ACTIVE').'--,--NAME--#--*'.GetMessage('iblock_routes_type_NAME').'--,--SORT--#--'.GetMessage('iblock_routes_type_SORT').'--;--', ));


COption::SetOptionString("bitrix.gossite", "routes_types_ib", $iblockID, WIZARD_SITE_ID, WIZARD_SITE_ID);

?>
