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

$iblockCode = "massmedia_".WIZARD_SITE_ID;
$iblockType = "massmedia";

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$massmedia.'/massmedia/index.php', array("MASSMEDIA_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$massmedia.'/massmedia/rss.php', array("MASSMEDIA_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$massmedia.'/info/massmedia/index.php', array("MASSMEDIA_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$massmedia.'/info/massmedia/rss.php', array("MASSMEDIA_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."about-bitrix/journal_of_operations.php", array("MASSMEDIA_IBLOCK_ID" => $iblockID));
    return;
}

$iblockID = WizardServices::ImportIBlockFromXML(
	WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID.'/massmedia/massmedia_'.$suffix.'.xml', 
	"gossite_massmedia",
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
    // "NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME"),
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

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$massmedia.'/massmedia/index.php', array("MASSMEDIA_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$massmedia.'/massmedia/rss.php', array("MASSMEDIA_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$massmedia.'/info/massmedia/index.php', array("MASSMEDIA_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$massmedia.'/info/massmedia/rss.php', array("MASSMEDIA_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."about-bitrix/journal_of_operations.php", array("MASSMEDIA_IBLOCK_ID" => $iblockID));

?>