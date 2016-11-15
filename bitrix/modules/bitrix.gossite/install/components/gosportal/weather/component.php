<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$included = CModule::IncludeModuleEx('bitrix.gossite');
if ($included==MODULE_NOT_FOUND) {
	ShowError(GetMessage('GOSSITE_MODULE_NOT_INSTALLED'));
	return;
}
if ($included==MODULE_DEMO_EXPIRED) {
	ShowError(GetMessage('GOSSITE_MODULE_DEMO_EXPIRED'));
	return;
}

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/classes/general/xml.php');

require_once(__DIR__.'/lang/'.LANGUAGE_ID.'/city.php');

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 300;
	
$arParams["DETAIL_URL"]=trim($arParams["DETAIL_URL"]);

if($arParams["CITY"]!='')
	$url = 'region='.substr($arParams["CITY"], 1).'&ts='.mktime();
else
	$url = 'ts='.mktime();

$cache = new CPageCache();
if($arParams["CACHE_TIME"]>0 && !$cache->StartDataCache($arParams["CACHE_TIME"], 'c'.$arParams["CITY"], "gdweather"))
	return;
	
$ob = new CHTTP();
$ob->http_timeout = 10;
$ob->Query(
	"GET",
	"export.yandex.ru",
	80,
	"/bar/reginfo.xml?".$url,
	false,
	"",
	"N"
	);


$errno = $ob->errno;
$errstr = $ob->errstr;

$res = $ob->result;

$res = str_replace("\xE2\x88\x92", "-", $res);

$xml = new CDataXML();
$xml->LoadString($APPLICATION->ConvertCharset($res, 'UTF-8', SITE_CHARSET));
$node = $xml->SelectNodes('/info/region/title');

$arResult=array();
$arResult["CITY_NAME"]=$node->content;

$node = $xml->SelectNodes('/info/weather/day/day_part/temperature');
$t = Intval($node->content);
$arResult["CLASS"]=intval($t/10);
$arResult["TEMPERATURE"]=$node->content;

$node = $xml->SelectNodes('/info/weather/day/day_part/image-v3');	
$arResult["WEATHER_PICTURE"]=$node->content;

$node = $xml->SelectNodes('/info/weather/day/day_part/weather_type');
$arResult["WEATHER_TYPE"]=$node->content;

$node = $xml->SelectNodes('/info/weather/day/day_part/wind_direction');
$arResult["WIND_DIRECTION"]=$node->content;

$node = $xml->SelectNodes('/info/weather/day/day_part/wind_speed');
$arResult["WIND_SPEED"]=$node->content;

$node = $xml->SelectNodes('/info/weather/day/day_part/pressure');
$arResult["PRESSURE"]=$node->content;

$node = $xml->SelectNodes('/info/weather/day/day_part/dampness');
$arResult["DAMPNESS"]=$node->content;

$node = $xml->SelectNodes('/info/weather/day/sun_rise');
$arResult["SUN_RISE"]=$node->content;

$node = $xml->SelectNodes('/info/weather/day/sunset');
$arResult["SUN_SET"]=$node->content;

$node = $xml->SelectNodes('info/weather/tonight/temperature');
if($node)
	$arResult["TONIGHT"]=$node->content;
	
$node = $xml->SelectNodes('/info/weather/tomorrow/temperature');
if($node)
	$arResult["TOMORROW"]=$node->content;

if($arParams["SHOW_URL"]=="Y"):
	$node = $xml->SelectNodes('/info/weather/url');
	$arResult["DETAIL_URL"]=htmlspecialchars($node->content);
endif;

$this->IncludeComponentTemplate();

$cache->EndDataCache();

