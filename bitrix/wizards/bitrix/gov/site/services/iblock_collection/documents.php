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

$iblockCode = "documents_".WIZARD_SITE_ID;
$iblockType = "documents"; 
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$heads."/documents/index.php", array("DOCUMENTS_IBLOCK_ID" => $iblockID));
    return;
}

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID.'/documents/documents'.$documents.'.xml'; 

$iblockID = WizardServices::ImportIBlockFromXML(
	$iblockXMLFile, 
	"gossite_documents",
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
	"FIELDS" => array(
		'LOG_SECTION_ADD'=>array('IS_REQUIRED' =>'Y'),
		'LOG_SECTION_EDIT'=>array('IS_REQUIRED' =>'Y'),
		'LOG_SECTION_DELETE'=>array('IS_REQUIRED' =>'Y'),
		'LOG_ELEMENT_ADD'=>array('IS_REQUIRED' =>'Y'),
		'LOG_ELEMENT_EDIT'=>array('IS_REQUIRED' =>'Y'),
		'LOG_ELEMENT_DELETE'=>array('IS_REQUIRED' =>'Y'),
		'IBLOCK_SECTION'  => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'ACTIVE'          => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'Y', ),
		'ACTIVE_FROM'     => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '=today', ),
		'ACTIVE_TO'       => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'SORT'            => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'NAME'            => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ),
		'PREVIEW_PICTURE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'PREVIEW_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => 'text', ),
		'PREVIEW_TEXT'      => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'DETAIL_PICTURE'    => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'DETAIL_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => 'text', ),
		'DETAIL_TEXT'      => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'XML_ID'           => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'CODE'             => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'TAGS'             => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
	)
);
$iblock->Update($iblockID, $arFields);

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$heads."/documents/index.php", array("DOCUMENTS_IBLOCK_ID" => $iblockID));
?>