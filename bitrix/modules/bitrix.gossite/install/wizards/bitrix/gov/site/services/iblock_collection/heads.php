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

$iblockCode = "administration_".WIZARD_SITE_ID;
$iblockType = "administration"; 
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
	$iblockID = $arIBlock["ID"]; 

if ($iblockID)
{
	CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", array("ADMINISTRATION_IBLOCK_ID" => $iblockID));
	return;
}

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH.'/xml/'.LANGUAGE_ID.'/heads/heads_'.$suffix.'.xml'; 

$iblockID = WizardServices::ImportIBlockFromXML(
	$iblockXMLFile, 
	"gossite_administration",
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
	
$arProperties = Array("POST", "PHONE", "FAX", "EMAIL", "ADDRESS");
foreach ($arProperties as $propertyName)
{
	${$propertyName."_PROPERTY_ID"} = 0;
	$properties = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID, "CODE" => $propertyName));
	if ($arProperty = $properties->Fetch())
		${$propertyName."_PROPERTY_ID"} = $arProperty["ID"];
}	

WizardServices::SetIBlockFormSettings($iblockID, array('tabs'=>GetMessage('ADMINISTRATION_TABS_1').$POST_PROPERTY_ID.GetMessage('ADMINISTRATION_TABS_2').$PHONE_PROPERTY_ID.GetMessage('ADMINISTRATION_TABS_3').$FAX_PROPERTY_ID.GetMessage('ADMINISTRATION_TABS_4').$EMAIL_PROPERTY_ID.GetMessage('ADMINISTRATION_TABS_5').$ADDRESS_PROPERTY_ID.GetMessage('ADMINISTRATION_TABS_6')));

//IBlock fields
$iblock = new CIBlock;
$arFields = Array(
	"ACTIVE" => "Y",
	"CODE" => $iblockCode,
    "XML_ID" => $iblockCode,
	"FIELDS" => array(
		'LOG_SECTION_ADD'=>array('IS_REQUIRED' =>'Y'),
		'LOG_SECTION_EDIT'=>array('IS_REQUIRED' =>'Y'),
		'LOG_SECTION_DELETE'=>array('IS_REQUIRED' =>'Y'),
		'LOG_ELEMENT_ADD'=>array('IS_REQUIRED' =>'Y'),
		'LOG_ELEMENT_EDIT'=>array('IS_REQUIRED' =>'Y'),
		'LOG_ELEMENT_DELETE'=>array('IS_REQUIRED' =>'Y'),
		'IBLOCK_SECTION'  => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
		'ACTIVE'          => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => 'Y', ),
		'ACTIVE_FROM'     => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
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
                'WIDTH' => 110,
                'HEIGHT' => 110,
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
                'WIDTH' => 240,
                'HEIGHT' => 240,
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

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$heads."/officials/index.php", array("ADMINISTRATION_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$heads."/about/officials/index.php", array("ADMINISTRATION_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."_index.php", array("ADMINISTRATION_IBLOCK_ID" => $iblockID));
?>