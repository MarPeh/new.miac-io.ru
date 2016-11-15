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

if ($suffix == 'progr' || $suffix == 'zags')
	return;

$iblockCode = "faq_".WIZARD_SITE_ID;
$iblockType = "feedback"; 
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."feedback/faq/index.php", array("FAQ_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."feedback/faq.php", array("FAQ_IBLOCK_ID" => $iblockID));
    return;
}

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/faq.xml"; 

$iblockID = WizardServices::ImportIBlockFromXML(
	$iblockXMLFile, 
	"gossite_faq",
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

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."feedback/faq/index.php", array("FAQ_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."feedback/faq.php", array("FAQ_IBLOCK_ID" => $iblockID));
?>