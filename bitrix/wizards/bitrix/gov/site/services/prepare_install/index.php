<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

use Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);

if (COption::GetOptionString("bitrix.gossite", "demo_type", "", WIZARD_SITE_ID) != ""
    && version_compare(COption::GetOptionString("bitrix.gossite", "template_version", false, WIZARD_SITE_ID), '4.0.0') < 0) {
    if (\Bitrix\Main\Loader::includeModule('iblock')) {

        //Replace code and iblock_type_id for IB map
        $newIBType    = '';
        $typeID       = 'guide_map';
        $arIBlockType = CIBlockType::GetList(array(), array('ID' => $typeID))->Fetch();
        if (empty($arIBlockType['ID'])) {
            $arIBlockType = array(
                "ID" => $typeID,
                "SECTIONS" => "Y",
                "IN_RSS" => "N",
                "SORT" => 180,
                "LANG" => array(
                    'ru' => array(
                        "NAME" => Loc::getMessage('IB_TYPE_NAME'),
                        "ELEMENT_NAME" => Loc::getMessage('IB_TYPE_ELEMENT_NAME'),
                        "SECTION_NAME" => Loc::getMessage('IB_TYPE_SECTION_NAME'),
                    )
                ),
            );
            $iblockType   = new CIBlockType;
            if ($iblockType->Add($arIBlockType)) {
                $newIBType = $typeID;
            }
        } else {
            $newIBType = $typeID;
        }

        $arReplaceName = array('GID_Objects'=>'map_objects', 'GID_routes'=>'map_routes', 'GID_events'=>'map_events');
        $iblock = new CIBlock;
        $arFilter = array(
            'SITE_ID' =>WIZARD_SITE_ID,
            'CODE' => array('GID_Objects_%', 'GID_routes_%', 'GID_events_%'),
            '!CODE' => 'GID_routes_types%'
        );
        $rsIBlock = CIBlock::GetList(array(), $arFilter);
        while ($arIBlock = $rsIBlock->Fetch()) {
            $lastLine = strrpos($arIBlock['CODE'], '_');
            $siteID =  substr($arIBlock['CODE'], $lastLine+1);
            $iblockName = substr($arIBlock['CODE'],0, $lastLine);
            
            $arFields = array('CODE'=>$arReplaceName[$iblockName].'_'.$siteID);
            if (!empty($newIBType)) {
                $arFields['IBLOCK_TYPE_ID'] = $newIBType;
            }
            $iblock->Update($arIBlock['ID'], $arFields);
            
        }
        //--End replace
    }
}