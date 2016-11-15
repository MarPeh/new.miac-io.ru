<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
    "AJAX_PATH" => array(
        "NAME" => GetMessage("T_MAP_DESC_AJAX_PATH"),
        "TYPE" => "STRING",
        "DEFAULT" => "/bitrix/components/bitrix/map.map/ajax.php",
    ),
    "BAR_HEIGHT" => array(
        "NAME" => GetMessage("T_MAP_DESC_BAR_HEIGHT"),
        "TYPE" => "STRING",
        "DEFAULT" => COption::GetOptionInt("bitrix.map", "def_bar_height"),
    ),
    "PLATE_HEIGHT" => array(
        "NAME" => GetMessage("T_MAP_DESC_PLATE_HEIGHT"),
        "TYPE" => "STRING",
        "DEFAULT" => COption::GetOptionInt("bitrix.map", "def_plate_height"),
    ),
    "FEW_OBJECTS_HEIGHT" => array(
        "NAME" => GetMessage("T_MAP_DESC_FEW_OBJECTS_HEIGHT"),
        "TYPE" => "STRING",
        "DEFAULT" => COption::GetOptionInt("bitrix.map", "def_few_objects_height"),
    ),
    "DIRECTION_LINK" => array(
        "NAME" => GetMessage("T_MAP_DESC_DIRECTION_LINK"),
        "TYPE" => "STRING",
        "DEFAULT" => "",
    ),
    "LOAD_ITEMS" => array(
        "NAME" => GetMessage("T_MAP_DESC_MAP_LOAD_ITEMS"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "Y"
    )
);
?>
