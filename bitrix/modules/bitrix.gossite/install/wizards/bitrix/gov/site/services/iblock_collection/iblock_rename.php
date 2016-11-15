<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
    die();

if (WIZARD_IS_RERUN)
    return;

if(!CModule::IncludeModule('iblock'))
    return;

$arRenameIblocks=array(
    array(
        "TMP_CODE"=>"gossite_gosserv",
        "NEW_CODE"=>"gosserv_".WIZARD_SITE_ID,
        "TYPE"=>"gosserv"
    ),
    array(
        "TMP_CODE"=>"gossite_photogallery",
        "NEW_CODE"=>"photogallery_".WIZARD_SITE_ID,
        "TYPE"=>"photovideogallery"
    ),
    array(
        "TMP_CODE"=>"gossite_videogallery",
        "NEW_CODE"=>"videogallery_".WIZARD_SITE_ID,
        "TYPE"=>"photovideogallery"
    ),
    array(
        "TMP_CODE"=>"gossite_administration",
        "NEW_CODE"=>"administration_".WIZARD_SITE_ID,
        "TYPE"=>"administration"
    ),
    array(
        "TMP_CODE"=>"gossite_gov-objects",
        "NEW_CODE"=>"gov-objects_".WIZARD_SITE_ID,
        "TYPE"=>"authorities"
    )
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