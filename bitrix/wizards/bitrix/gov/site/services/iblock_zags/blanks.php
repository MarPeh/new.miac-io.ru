<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock"))
	return;
$iblockCode = "blanks_".WIZARD_SITE_ID;
$iblockType = "documents";
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."feedback/blanks.php", array("BLANK_IBLOCK_ID" => $iblockID));
    return;
}

$iblockID = WizardServices::ImportIBlockFromXML(
	WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/blanks.xml", 
	"gossite_blanks",
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

$iblock = new CIBlock;
$arFields = Array(
    "ACTIVE" => "Y",
    "CODE" => $iblockCode,
    "XML_ID" => $iblockCode,
    // "NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME"),
);
$iblock->Update($iblockID, $arFields);

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."feedback/blanks.php", array("BLANK_IBLOCK_ID" => $iblockID));
?>