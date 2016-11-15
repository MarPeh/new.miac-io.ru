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

if (!in_array($suffix, array('mo','gd','po','zso')))
    return;

WizardServices::IncludeServiceLang('map.php', LANGUAGE_ID);

$iblockType = 'guide_map';
$iblockCode = "map_objects_".WIZARD_SITE_ID;
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    $iblock = new CIBlock;
    $arFields = array(
        "LIST_PAGE_URL" => '#SITE_DIR#'.ltrim($path,"/")."/turizm/",
        "SECTION_PAGE_URL" => '#SITE_DIR#'.ltrim($path,"/")."/turizm/?cat=s#SECTION_ID#",
        "DETAIL_PAGE_URL" => '#SITE_DIR#'.ltrim($path,"/")."/turizm/detail_objects.php?ID=#ELEMENT_ID#"
    );
    $iblock->Update($iblockID, $arFields);
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/index.php", array("GID_OBJECTS_IBLOCK" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/detail_objects.php", array("GID_OBJECTS_IBLOCK" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/detail_objects.php", array("GID_BACK_URL" => WIZARD_SITE_DIR.ltrim($path,"/")));

    if (COption::GetOptionString("bitrix.gossite", "demo_type", "", WIZARD_SITE_ID) != ""
        && version_compare(COption::GetOptionString("bitrix.gossite", "template_version", false, WIZARD_SITE_ID), '4.0.0') < 0) {
        $arFileName = array(
            WIZARD_SITE_PATH.$path."/turizm/index.php",
            WIZARD_SITE_PATH.$path."/turizm/detail_objects.php"
        );
        foreach ($arFileName as $fileName) {
            if (is_writeable($fileName)) {
                $data = file_get_contents($fileName);
                file_put_contents(substr($fileName, 0, -4).".old.v3.php", $data);
                $data = preg_replace('#("IBLOCK_TYPE"\s*=>\s*")(information)"#i', '${1}guide_map"', $data, 1);
                file_put_contents($fileName, $data);
            }
        }
    }
    
    return;
}

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH.'/xml/'.LANGUAGE_ID.'/objects.xml';

$iblockID = WizardServices::ImportIBlockFromXML(
    $iblockXMLFile,
    $iblockCode,
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
    "LIST_PAGE_URL" => '#SITE_DIR#'.ltrim($path,"/")."/turizm/",
	"SECTION_PAGE_URL" => '#SITE_DIR#'.ltrim($path,"/")."/turizm/?cat=s#SECTION_ID#",
	"DETAIL_PAGE_URL" => '#SITE_DIR#'.ltrim($path,"/")."/turizm/detail_objects.php?ID=#ELEMENT_ID#",
//    "NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME"),
);

$iblock->Update($iblockID, $arFields);

$dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => 'IBLOCK_'.$iblockID.'_SECTION', "FIELD_NAME" => 'UF_ICON_POS'));
if ($arProp = $dbRes->Fetch()) {
    $propID = $arProp['ID'];
    $arProp["EDIT_FORM_LABEL"] = array('ru' => GetMessage('GOSMAP_UF_ICON_POS_text'), 'en' => 'Icon position');
    $arProp["LIST_COLUMN_LABEL"] = array('ru' => GetMessage('GOSMAP_UF_ICON_POS_text'), 'en' => 'Icon position');
    $arProp["LIST_FILTER_LABEL"] = array('ru' => GetMessage('GOSMAP_UF_ICON_POS_text'), 'en' => 'Icon position');
    unset ($arProp['ID']);
    $userType = new CUserTypeEntity();
    $userType->Update($propID, $arProp);
}

$arProperties = Array("ADDRESS","LINK","PHONE","OPENING","LAT","LNG",);
$arrPropID=array();
foreach ($arProperties as $propertyName)
{
    $arrPropID[$propertyName] = 0;
    $properties = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID, "CODE" => $propertyName));
    if ($arProperty = $properties->Fetch()) {
        $arrPropID[$propertyName] = $arProperty["ID"];
    }
}
COption::SetOptionString("bitrix.gossite", "objects_address", $arrPropID["ADDRESS"], WIZARD_SITE_ID, WIZARD_SITE_ID);
COption::SetOptionString("bitrix.gossite", "objects_lat", $arrPropID["LAT"], WIZARD_SITE_ID, WIZARD_SITE_ID);
COption::SetOptionString("bitrix.gossite", "objects_lng", $arrPropID["LNG"], WIZARD_SITE_ID, WIZARD_SITE_ID);

COption::SetOptionString("bitrix.gossite", "objects_ib", $iblockID, WIZARD_SITE_ID, WIZARD_SITE_ID);
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/index.php", array("GID_OBJECTS_IBLOCK" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/detail_objects.php", array("GID_OBJECTS_IBLOCK" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/detail_objects.php", array("GID_BACK_URL" => WIZARD_SITE_DIR.ltrim($path,"/")));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/index.php", array("GID_DETAIL_URL" => WIZARD_SITE_DIR.ltrim($path,"/").'/turizm/detail_objects.php?ID=#ELEMENT_ID#'));

?>
