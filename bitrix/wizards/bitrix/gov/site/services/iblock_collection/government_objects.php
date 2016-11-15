<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock"))
	return;
if (!in_array(WIZARD_INSTALL_DEMO_TYPE,array('demo_mo','demo_gd','demo_po','demo_zso')))
	return;
if(WIZARD_INSTALL_MOBILE_VERSION != "Y")
    return;

$dir = dirname(__FILE__).'/lang/'.LANGUAGE_ID.'/';
if (file_exists($dir.'_iblockDataSelect.php')) {
	require ('lang/'.LANGUAGE_ID.'/_iblockDataSelect.php');
} else {
	require ('lang/'.LANGUAGE_ID.'/_iblockdataselect.php');
}

$iblockCode = "gov-objects_".WIZARD_SITE_ID;
$iblockType = 'authorities';

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.WIZARD_SITE_DIR.'/mobile_app/city/authorities/government/object.php', array('GOV_OBJECTS_IBLOCK_ID' => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.WIZARD_SITE_DIR.'/mobile_app/city/authorities/government/index.php', array('GOV_OBJECTS_IBLOCK_ID' => $iblockID));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.WIZARD_SITE_DIR.'/mobile_app/city/authorities/government/direction/index.php', array('GOV_OBJECTS_IBLOCK_ID' => $iblockID));
    return;
}


$iblockID = WizardServices::ImportIBlockFromXML(
	WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID.'/ministry/government_objects.xml', 
	"gossite_gov-objects",
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

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.WIZARD_SITE_DIR.'/mobile_app/city/authorities/government/index.php', array('GOV_OBJECTS_IBLOCK_ID' => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.WIZARD_SITE_DIR."/mobile_app/city/authorities/government/object.php", array("GOV_OBJECTS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.WIZARD_SITE_DIR.'/mobile_app/city/authorities/government/direction/index.php', array('GOV_OBJECTS_IBLOCK_ID' => $iblockID));

?>