<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
    die();

if (WIZARD_IS_RERUN)
    return;

if(!CModule::IncludeModule('iblock'))
    return;
$arRenameIblocks=array(
    array(
        "TMP_CODE"=>"gossite_podrazdel",
        "NEW_CODE"=>"podrazdel_".WIZARD_SITE_ID,
        "TYPE"=>"mypolice"
    ),
    array(
        "TMP_CODE"=>"gossite_opor",
        "NEW_CODE"=>"opor_".WIZARD_SITE_ID,
        "TYPE"=>"mypolice"
    ),
    array(
        "TMP_CODE"=>"gossite_territory_info",
        "NEW_CODE"=>"territory_info_".WIZARD_SITE_ID,
        "TYPE"=>"mypolice"
    ),
);
foreach($arRenameIblocks as $ib)
{
    $rsIBlock = CIBlock::GetList(array(), array("CODE" => $ib['TMP_CODE'], "TYPE" => $ib['TYPE']));
    if ($arIBlock = $rsIBlock->Fetch())
    {
        $iblock = new CIBlock;
        $arFields = Array(
            "ACTIVE" => "Y",
            "CODE" => $ib['NEW_CODE'],
            "XML_ID" => $ib['NEW_CODE'],
            // "NAME" => "[".WIZARD_SITE_ID."] ".CIBlock::GetArrayByID($arIBlock['ID'], "NAME"),
            "FIELDS" => array(
                'LOG_SECTION_ADD'=>array('IS_REQUIRED' =>'Y'),
                'LOG_SECTION_EDIT'=>array('IS_REQUIRED' =>'Y'),
                'LOG_SECTION_DELETE'=>array('IS_REQUIRED' =>'Y'),
                'LOG_ELEMENT_ADD'=>array('IS_REQUIRED' =>'Y'),
                'LOG_ELEMENT_EDIT'=>array('IS_REQUIRED' =>'Y'),
                'LOG_ELEMENT_DELETE'=>array('IS_REQUIRED' =>'Y'),
            )
        );
        $iblock->Update($arIBlock['ID'], $arFields);
    }
}
?>