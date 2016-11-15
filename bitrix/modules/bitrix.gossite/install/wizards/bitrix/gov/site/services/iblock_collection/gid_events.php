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

$iblockCode = "GID_events_".WIZARD_SITE_ID;
$iblockType = "information"; 
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
	$iblockID = $arIBlock["ID"];

if ($iblockID)
{
	return;
}

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/gid_events/gid_events.xml";

$iblockID = WizardServices::ImportIBlockFromXML(
	$iblockXMLFile, 
	"gossite_GID_events",
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
	"LIST_PAGE_URL" => $path."/turizm/events.php",
	"SECTION_PAGE_URL" => $path."/turizm/events.php",
	"DETAIL_PAGE_URL" => $path."/turizm/detail_events.php?ID=#ELEMENT_ID#",
    "XML_ID" => $iblockCode,
    // "NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME"),
);
$iblock->Update($iblockID, $arFields);

$arProperties = Array("ADDRESS","LINK","OPENING","LAT","LNG");
$arrPropID=array();

COption::SetOptionString("bitrix.gossite", "events_ib", $iblockID, WIZARD_SITE_ID, WIZARD_SITE_ID);

foreach ($arProperties as $propertyName)
{
	$arrPropID[$propertyName] = 0;
	$properties = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID, "CODE" => $propertyName));
	if ($arProperty = $properties->Fetch()) {
		$arrPropID[$propertyName] = $arProperty["ID"];
	}
}
COption::SetOptionString("bitrix.gossite", "events_address", $arrPropID["ADDRESS"], WIZARD_SITE_ID, WIZARD_SITE_ID);
COption::SetOptionString("bitrix.gossite", "events_lat", $arrPropID["LAT"], WIZARD_SITE_ID, WIZARD_SITE_ID);
COption::SetOptionString("bitrix.gossite", "events_lng", $arrPropID["LNG"], WIZARD_SITE_ID, WIZARD_SITE_ID);

WizardServices::SetIBlockFormSettings($iblockID, Array ( 'tabs' => 'edit1--#--'.GetMessage('iblock_GID_events_edit1').'--,--ACTIVE--#--'.GetMessage('iblock_GID_events_ACTIVE').'--,--NAME--#--*'.GetMessage('iblock_GID_events_NAME').'--,--ACTIVE_FROM--#--'.GetMessage('iblock_GID_events_ACTIVE_FROM').'--,--ACTIVE_TO--#--'.GetMessage('iblock_GID_events_ACTIVE_TO').'--,--PROPERTY_'.$arrPropID['OPENING'].'--#--'.GetMessage('iblock_GID_events_OPENING').'--,--PROPERTY_'.$arrPropID['ADDRESS'].'--#--'.GetMessage('iblock_GID_events_ADDRESS').'--,--PROPERTY_'.$arrPropID['LINK'].'--#--'.GetMessage('iblock_GID_events_LINK').'--,--IBLOCK_ELEMENT_PROP_VALUE--#----'.GetMessage('iblock_GID_COOORD_VALUE').'--,--PROPERTY_'.$arrPropID['LAT'].'--#--'.GetMessage('iblock_GID_events_LAT').'--,--PROPERTY_'.$arrPropID['LNG'].'--#--'.GetMessage('iblock_GID_events_LNG').'--;--edit5--#--'.GetMessage('iblock_GID_events_edit5').'--,--PREVIEW_PICTURE--#--'.GetMessage('iblock_GID_events_PREVIEW_PICTURE').'--,--PREVIEW_TEXT--#--'.GetMessage('iblock_GID_events_PREVIEW_TEXT').'--;--edit6--#--'.GetMessage('iblock_GID_events_edit6').'--,--DETAIL_PICTURE--#--'.GetMessage('iblock_GID_events_DETAIL_PICTURE').'--,--DETAIL_TEXT--#--'.GetMessage('iblock_GID_events_DETAIL_TEXT').'--;--', ));


CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/events.php", array("GID_EVENTS_IBLOCK" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/detail_events.php", array("GID_EVENTS_IBLOCK" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/detail_events.php", array("GID_BACK_URL" => WIZARD_SITE_DIR.ltrim($path,"/")));
?>
