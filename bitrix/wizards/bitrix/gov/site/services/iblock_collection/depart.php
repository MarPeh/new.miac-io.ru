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

$iblockCode = "depart_".WIZARD_SITE_ID;
$iblockType = 'gosserv'; 
$iblockID = false;


$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
	$iblockID = $arIBlock["ID"];

if ($iblockID)
{
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/gosserv/index.php', array('DEPART_IBLOCK_ID' => $iblockID));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/_index.php', array('DEPART_IBLOCK_ID' => $iblockID));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/activity/gosserv/index.php', array('DEPART_IBLOCK_ID' => $iblockID));

	return;
}


$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH.'/xml/'.LANGUAGE_ID.'/depart/depart.xml'; 

$iblockID = WizardServices::ImportIBlockFromXML(
	$iblockXMLFile, 
	"gossite_depart",
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

//IBlock fields
$iblock = new CIBlock;
$arFields = Array(
	"ACTIVE" => "Y",
    "CODE" => $iblockCode,
    "XML_ID" => $iblockCode
);

$iblock->Update($iblockID, $arFields);


CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/gosserv/index.php', array('DEPART_IBLOCK_ID' => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/_index.php', array('DEPART_IBLOCK_ID' => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'/activity/gosserv/index.php', array('DEPART_IBLOCK_ID' => $iblockID));
?>