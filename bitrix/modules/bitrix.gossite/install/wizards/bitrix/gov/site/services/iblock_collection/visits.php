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

if ($suffix == 'progr')
	$iblockCode = "statistics_".WIZARD_SITE_ID;
else
	$iblockCode = "visits_".WIZARD_SITE_ID;
$iblockType = "visits"; 
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
	$iblockID = $arIBlock["ID"]; 

if ($iblockID)
{
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", array("VISITS_IBLOCK_ID" => $iblockID));
	if ($suffix == 'progr')
		CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."program/statistics/index.php", array("VISITS_IBLOCK_ID" => $iblockID));
	else
		CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."about/visits/index.php", array("VISITS_IBLOCK_ID" => $iblockID));
	return;
}

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID.'/visits/visits_'.$suffix.'.xml'; 

$iblockID = WizardServices::ImportIBlockFromXML(
	$iblockXMLFile, 
	"gossite_visits",
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

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", array("VISITS_IBLOCK_ID" => $iblockID));
if ($suffix == 'progr')
{
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."program/statistics/index.php", array("VISITS_IBLOCK_ID" => $iblockID));
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."program/statistics/rss.php", array("VISITS_IBLOCK_ID" => $iblockID));
}
elseif ($suffix == 'dep'){
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."exhibition/itogi/index.php", array("VISITS_IBLOCK_ID" => $iblockID));
}
else {
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."about/visits/index.php", array("VISITS_IBLOCK_ID" => $iblockID));
}

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
		'IBLOCK_SECTION'  => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'ACTIVE'          => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'Y', ),
		'ACTIVE_FROM'     => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '=today', ),
		'ACTIVE_TO'       => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'SORT'            => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'NAME'            => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ),
		'PREVIEW_PICTURE' => array (
			'IS_REQUIRED' => 'N',
			'DEFAULT_VALUE' => array (
				'FROM_DETAIL' => 'Y',
				'DELETE_WITH_DETAIL' => 'Y',
				'UPDATE_WITH_DETAIL' => 'Y',
				'SCALE' => 'Y',
				'WIDTH' => 210,
				'HEIGHT' => 150,
				'IGNORE_ERRORS' => 'Y',
				'METHOD' => 'resample',
				'COMPRESSION' => 95,
			),
		),
		'PREVIEW_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'text', ),
		'PREVIEW_TEXT'      => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'DETAIL_PICTURE' => array (
			'IS_REQUIRED' => 'N',
			'DEFAULT_VALUE' => array (
				'SCALE' => 'Y',
				'WIDTH' => 310,
				'HEIGHT' => 230,
				'IGNORE_ERRORS' => 'Y',
				'METHOD' => 'resample',
				'COMPRESSION' => 95,
			),
		),
		'DETAIL_TEXT_TYPE' => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'html', ),
		'DETAIL_TEXT'      => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'XML_ID'           => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'CODE'             => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'TAGS'             => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
	)
);

$iblock->Update($iblockID, $arFields);

?>