<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
    die();

if(WIZARD_INSTALL_MOBILE_VERSION != "Y")
    return;

if(!CModule::IncludeModule("iblock"))
    return;

$iblockCode = "phonebook_".WIZARD_SITE_ID;
$iblockType = 'phonebook';
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    $arFindSect=array("emergencies","helplines");
    $arFindedSect=array();
    foreach($arFindSect as $code)
    {
        $arFilter = Array('IBLOCK_ID'=>$iblockID, "CODE"=>$code);
        $db_list = CIBlockSection::GetList(Array(), $arFilter, false, array("ID"));
        while($ar_result = $db_list->Fetch())
        {
            $arFindedSect[$code]=$ar_result['ID'];
        }
    }

    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.WIZARD_SITE_DIR.'/mobile_app/city/emergencies/index.php', array('PHONEBOOK_IBLOCK_ID' => $iblockID, 'EMERGENCIES_SECTION_ID' => $arFindedSect["emergencies"]));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.WIZARD_SITE_DIR.'/mobile_app/city/helplines/index.php', array('PHONEBOOK_IBLOCK_ID' => $iblockID, 'HELPLINES_SECTION_ID' => $arFindedSect["helplines"]));
    return;
}

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH.'/xml/'.LANGUAGE_ID.'/phonebook.xml';

$iblockID = WizardServices::ImportIBlockFromXML(
    $iblockXMLFile,
    "gossite_phonebook",
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
    'ACTIVE' => 'Y',
    "CODE" => $iblockCode,
    "XML_ID" => $iblockCode,
    "NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME"),
    'FIELDS' => array(
        'LOG_SECTION_ADD'=>array('IS_REQUIRED' =>'Y'),
        'LOG_SECTION_EDIT'=>array('IS_REQUIRED' =>'Y'),
        'LOG_SECTION_DELETE'=>array('IS_REQUIRED' =>'Y'),
        'LOG_ELEMENT_ADD'=>array('IS_REQUIRED' =>'Y'),
        'LOG_ELEMENT_EDIT'=>array('IS_REQUIRED' =>'Y'),
        'LOG_ELEMENT_DELETE'=>array('IS_REQUIRED' =>'Y'),
    )
);

$iblock->Update($iblockID, $arFields);

$arFindSect=array("emergencies","helplines");
$arFindedSect=array();
foreach($arFindSect as $code)
{
    $arFilter = Array('IBLOCK_ID'=>$iblockID, "CODE"=>$code);
    $db_list = CIBlockSection::GetList(Array(), $arFilter, false, array("ID"));
    while($ar_result = $db_list->Fetch())
    {
        $arFindedSect[$code]=$ar_result['ID'];
    }
}

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.WIZARD_SITE_DIR.'/mobile_app/city/emergencies/index.php', array('PHONEBOOK_IBLOCK_ID' => $iblockID, 'EMERGENCIES_SECTION_ID' => $arFindedSect["emergencies"]));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.WIZARD_SITE_DIR.'/mobile_app/city/helplines/index.php', array('PHONEBOOK_IBLOCK_ID' => $iblockID, 'HELPLINES_SECTION_ID' => $arFindedSect["helplines"]));
?>