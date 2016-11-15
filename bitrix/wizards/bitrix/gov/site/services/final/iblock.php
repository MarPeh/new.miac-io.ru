<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (\Bitrix\Main\Loader::includeModule('iblock')) {
    $objIBlock = new CIBlock;
    $rsIBlock = CIBlock::GetList(array(), array("SITE_ID" => WIZARD_SITE_ID, 'NAME' => '['.WIZARD_SITE_ID.']%'));
    while ($arIBlock = $rsIBlock->Fetch()) {
        $objIBlock->Update($arIBlock['ID'], array('NAME' => str_replace('['.WIZARD_SITE_ID.'] ', '', $arIBlock['NAME'])));
    }
}