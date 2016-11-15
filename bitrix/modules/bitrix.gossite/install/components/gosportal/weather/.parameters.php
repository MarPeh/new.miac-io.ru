<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
include(__DIR__.'/lang/'.LANGUAGE_ID.'/city.php');
asort($arCity);

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS"  =>  array(		
		"CITY"  =>  Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CITY"),
			"TYPE" => "LIST",
			"DEFAULT" => "DESC",
			"VALUES" => $arCity,
		),		
		"SHOW_URL" => Array(
					"PARENT" => "BASE",
					"NAME" => GetMessage("SHOW_DETAIL_URL"),
					"TYPE" => "CHECKBOX",
					"MULTIPLE" => "N",
					"DEFAULT" => "",
				),			
		"CACHE_TIME"  =>  Array("DEFAULT"=>300),		
	),
);
?>
