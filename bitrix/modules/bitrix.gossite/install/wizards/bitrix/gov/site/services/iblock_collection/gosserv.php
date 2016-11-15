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

$iblockCode = "gossite_gosserv";
$iblockType = "gosserv";
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
	$iblockID = $arIBlock["ID"];

if ($iblockID)
{
	$arSites = array();
	$db_res  = CIBlock::GetSite($iblockID);
	while ($res = $db_res->Fetch()) {
		$arSites[] = $res["LID"];
	}
	if (!in_array(WIZARD_SITE_ID, $arSites)) {
		$arSites[] = WIZARD_SITE_ID;
		$iblock    = new CIBlock;
		$iblock->Update($iblockID, array("LID" => $arSites));
	}

	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", array("GOSSERV_IBLOCK_ID" => $iblockID));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."gosserv/index.php", array("GOSSERV_IBLOCK_ID" => $iblockID));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."activity/gosserv/index.php", array("GOSSERV_IBLOCK_ID" => $iblockID));
	return;
}


$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID.'/gosserv/gosserv'.$gosserv.'.xml'; 

$iblockID = WizardServices::ImportIBlockFromXML(
	$iblockXMLFile, 
	"gossite_gosserv",
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

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", array("GOSSERV_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."gosserv/index.php", array("GOSSERV_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."activity/gosserv/index.php", array("GOSSERV_IBLOCK_ID" => $iblockID));
?>