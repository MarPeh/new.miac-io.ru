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

$iblockCode = "ministry_".WIZARD_SITE_ID;
$iblockType = 'authorities';

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.WIZARD_SITE_DIR.'/mobile_app/city/authorities/departments/index.php', array('MINISTRY_IBLOCK_ID' => $iblockID));
    return;
}


$iblockID = WizardServices::ImportIBlockFromXML(
	WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID.'/ministry/minesterstva.xml', 
	"gossite_ministry",
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
    "XML_ID" => $iblockCode,
    "NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME"),
	"FIELDS" => array(
		'LOG_SECTION_ADD'=>array('IS_REQUIRED' =>'Y'),
		'LOG_SECTION_EDIT'=>array('IS_REQUIRED' =>'Y'),
		'LOG_SECTION_DELETE'=>array('IS_REQUIRED' =>'Y'),
		'LOG_ELEMENT_ADD'=>array('IS_REQUIRED' =>'Y'),
		'LOG_ELEMENT_EDIT'=>array('IS_REQUIRED' =>'Y'),
		'LOG_ELEMENT_DELETE'=>array('IS_REQUIRED' =>'Y'),
	)
);

$iblock->Update($iblockID, $arFields);

    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.WIZARD_SITE_DIR.'/mobile_app/city/authorities/departments/index.php', array('MINISTRY_IBLOCK_ID' => $iblockID));

?>