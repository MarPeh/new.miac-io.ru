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

$iblockCode = "slider_".WIZARD_SITE_ID;
$iblockType = "information";
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."_".WIZARD_THEME_ID."_".WIZARD_SITE_ID."/header.php", array("SLIDER_IBLOCK_ID" => $iblockID));
    return;
}

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH.'/xml/'.LANGUAGE_ID.'/slider.xml';

$iblockID = WizardServices::ImportIBlockFromXML(
    $iblockXMLFile,
    "slider",
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

WizardServices::SetIBlockFormSettings($iblockID, array('tabs'=>GetMessage('SLIDER_TABS')));

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
        'ACTIVE'          => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
        'ACTIVE_FROM'     => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
        'ACTIVE_TO'       => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
        'SORT'            => array ( 'IS_REQUIRED' => 'N', 'DEFAULT_VALUE' => '', ),
        'NAME'            => array ( 'IS_REQUIRED' => 'Y', 'DEFAULT_VALUE' => '', ),
        'PREVIEW_PICTURE' => array (
            'IS_REQUIRED' => 'N',
            'DEFAULT_VALUE' => array (
                'FROM_DETAIL' => 'N',
                'DELETE_WITH_DETAIL' => 'N',
                'UPDATE_WITH_DETAIL' => 'N',
                'SCALE' => 'N',
                'WIDTH' => '',
                'HEIGHT' => '',
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
                'SCALE' => 'N',
                'WIDTH' => '',
                'HEIGHT' => '',
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

CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"].BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."_".WIZARD_THEME_ID."_".WIZARD_SITE_ID."/header.php", array("SLIDER_IBLOCK_ID" => $iblockID));
?>