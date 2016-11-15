<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$obDataMixer = new \Bitrix\InteractiveMap\DataMixer($arParams);

$arParams["BAR_HEIGHT"] = IntVal($arParams["BAR_HEIGHT"]);
if (empty($arParams["BAR_HEIGHT"]))
{
    $arParams["BAR_HEIGHT"] = $obDataMixer->GetDefaultBarHeight();
}
if ($arParams["BAR_HEIGHT"] < 0)
{
    $arParams["BAR_HEIGHT"] = 0;
}

$arParams["PLATE_HEIGHT"] = IntVal($arParams["PLATE_HEIGHT"]);
if (empty($arParams["PLATE_HEIGHT"]))
{
    $arParams["PLATE_HEIGHT"] = $obDataMixer->GetDefaultPlateHeight();
}
if ($arParams["PLATE_HEIGHT"] < 0)
{
    $arParams["PLATE_HEIGHT"] = 0;
}

$arParams["DIRECTION_LINK"] = CUtil::JSEscape($arParams["DIRECTION_LINK"]);

$arResult["PARAMS"]["ICONS"] = $obDataMixer->GetIconsSettings("mobile", array(
    "icon_" . $arParams["DATA_TYPE"],
    "cluster"
), true);

if (!empty($arParams["AJAX_PATH"]))
{
    $query[] = "mobile=Y";
    $query[] = "version=3";

    $uri = parse_url($arParams["AJAX_PATH"]);
    $arParams["AJAX_PATH"] = $arParams["AJAX_PATH"] . (empty($uri["query"]) ? "?" : "&") . implode("&", $query);

}
$arResult["JSON_FIELDS"] = !empty($arResult["JSON_FIELDS"]) ? Bitrix\Main\Web\Json::encode($arResult["JSON_FIELDS"], JSON_FORCE_OBJECT) : '';
?>