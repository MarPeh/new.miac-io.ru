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

$iblockCode = "GID_Objects_".WIZARD_SITE_ID;
$iblockType = "information";

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
	$iblockID = $arIBlock["ID"];

if ($iblockID)
{
	return;
}

$iblockID = false;

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/gid_objects/gid_objects.xml";

$iblockID = WizardServices::ImportIBlockFromXML(
	$iblockXMLFile, 
	"gossite_GID_Objects",
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
	"LIST_PAGE_URL" => $path."/turizm/",
	"SECTION_PAGE_URL" => $path."/turizm/",
	"DETAIL_PAGE_URL" => $path."/turizm/detail_objects.php?ID=#ELEMENT_ID#",
    "XML_ID" => $iblockCode,
    // "NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME"),
);
$iblock->Update($iblockID, $arFields);

$arProperties = Array("ADDRESS","LINK","PHONE","OPENING","LAT","LNG",);
$arrPropID=array();
foreach ($arProperties as $propertyName)
{
	$arrPropID[$propertyName] = 0;
	$properties = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID, "CODE" => $propertyName));
	if ($arProperty = $properties->Fetch()) {
		$arrPropID[$propertyName] = $arProperty["ID"];
	}
}
COption::SetOptionString("bitrix.gossite", "objects_address", $arrPropID["ADDRESS"], WIZARD_SITE_ID, WIZARD_SITE_ID);
COption::SetOptionString("bitrix.gossite", "objects_lat", $arrPropID["LAT"], WIZARD_SITE_ID, WIZARD_SITE_ID);
COption::SetOptionString("bitrix.gossite", "objects_lng", $arrPropID["LNG"], WIZARD_SITE_ID, WIZARD_SITE_ID);


WizardServices::SetUserOption('form', 'form_section_'.$iblockID, Array ( 'tabs' => 'edit1--#--'.GetMessage('iblock_GID_Objects_edit1_sect').'--,--'.GetMessage('iblock_GID_Objects_ID_sect').'--#--'.GetMessage('iblock_GID_Objects_ID_sect').'--,--DATE_CREATE--#--'.GetMessage('iblock_GID_Objects_DATE_CREATE_sect').'--,--TIMESTAMP_X--#--'.GetMessage('iblock_GID_Objects_TIMESTAMP_X_sect').'--,--ACTIVE--#--'.GetMessage('iblock_GID_Objects_ACTIVE_sect').'--,--IBLOCK_SECTION_'.GetMessage('iblock_GID_Objects_ID_sect').'--#--'.GetMessage('iblock_GID_Objects_IBLOCK_SECTION_ID_sect').'--,--NAME--#--*'.GetMessage('iblock_GID_Objects_NAME_sect').'--,--CODE--#--'.GetMessage('iblock_GID_Objects_CODE_sect').'--;--', ), true, false);
WizardServices::SetIBlockFormSettings($iblockID, Array ( 'tabs' => 'edit1--#--'.GetMessage('iblock_GID_Objects_edit1').'--,--ACTIVE--#--'.GetMessage('iblock_GID_Objects_ACTIVE').'--,--ACTIVE_FROM--#--'.GetMessage('iblock_GID_Objects_ACTIVE_FROM').'--,--ACTIVE_TO--#--'.GetMessage('iblock_GID_Objects_ACTIVE_TO').'--,--NAME--#--*'.GetMessage('iblock_GID_Objects_NAME').'--,--PROPERTY_'.$arrPropID['ADDRESS'].'--#--'.GetMessage('iblock_GID_Objects_ADDRESS').'--,--PROPERTY_'.$arrPropID['OPENING'].'--#--'.GetMessage('iblock_GID_Objects_OPENING').'--,--PROPERTY_'.$arrPropID['LINK'].'--#--'.GetMessage('iblock_GID_Objects_LINK').'--,--PROPERTY_'.$arrPropID['PHONE'].'--#--'.GetMessage('iblock_GID_Objects_PHONE').'--,--IBLOCK_ELEMENT_PROP_VALUE--#----'.GetMessage('iblock_GID_COOORD_VALUE').'--,--PROPERTY_'.$arrPropID['LAT'].'--#--'.GetMessage('iblock_GID_Objects_LAT').'--,--PROPERTY_'.$arrPropID['LNG'].'--#--'.GetMessage('iblock_GID_Objects_LNG').'--;--edit5--#--'.GetMessage('iblock_GID_Objects_edit5').'--,--PREVIEW_PICTURE--#--'.GetMessage('iblock_GID_Objects_PREVIEW_PICTURE').'--,--PREVIEW_TEXT--#--'.GetMessage('iblock_GID_Objects_PREVIEW_TEXT').'--;--edit2--#--'.GetMessage('iblock_GID_Objects_edit2').'--,--SECTIONS--#--'.GetMessage('iblock_GID_Objects_edit2').'--;--', ));

COption::SetOptionString("bitrix.gossite", "objects_ib", $iblockID, WIZARD_SITE_ID, WIZARD_SITE_ID);
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."mobile_app/guide/objects/index.php", array("GID_OBJECTS_IBLOCK" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."mobile_app/guide/objects/category/index.php", array("GID_OBJECTS_IBLOCK" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."mobile_app/guide/objects/direction/index.php", array("GID_OBJECTS_IBLOCK" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/index.php", array("GID_OBJECTS_IBLOCK" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/detail_objects.php", array("GID_OBJECTS_IBLOCK" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/detail_objects.php", array("GID_BACK_URL" => WIZARD_SITE_DIR.ltrim($path,"/")));
?>
