<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock"))
	return;
$iblockCode = "territory_info_".WIZARD_SITE_ID;
$iblockType = "mypolice";
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."city/mypolice/index.php", array("UUMTERRITORY_IBLOCK_ID" => $iblockID));
    return;
}

$iblockID = WizardServices::ImportIBlockFromXML(
	WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/territory_info.xml", 
	"gossite_territory_info",
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

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."city/mypolice/index.php", array("UUMTERRITORY_IBLOCK_ID" => $iblockID));
?>