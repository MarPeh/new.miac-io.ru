<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	"NAME" => GetMessage("T_MAP_DESC_LIST"),
	"DESCRIPTION" => GetMessage("T_MAP_DESC_LIST_DESC"),
	"ICON" => "/images/map.gif",
	"SORT" => 20,
	"CACHE_PATH" => "Y",
	"PATH" => array(
		"ID" => "gossite",
		"NAME" => GetMessage('T_GOSSITE_SECTION_NAME'),
	),
);
?>