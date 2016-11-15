<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
if (!CModule::IncludeModule("iblock")) {
    return;
}

$arResult["CURRENT_PROPERTY"] = $_REQUEST["PROPERTY"];

$res = CIBlockSection::GetByID($arResult["IBLOCK_SECTION_ID"]);
if ($ar_res = $res->GetNext()) {
    $arResult["SECTION_NAME"] = $ar_res["NAME"];
}

if (!empty($arResult["DISPLAY_PROPERTIES"]["FOR"]["VALUE"])) {
    if (!is_array($arResult["DISPLAY_PROPERTIES"]["FOR"]["VALUE"])) {
        $arResult["DISPLAY_PROPERTIES"]["FOR"]["VALUE"] = array($arResult["DISPLAY_PROPERTIES"]["FOR"]["VALUE"]);
    }

    $arResult["DISPLAY_PROPERTIES"]["FOR"]["DISPLAY_VALUE"] = array();

    foreach ($arResult["DISPLAY_PROPERTIES"]["FOR"]["VALUE"] as $keyFor => $forName) {
        $arResult["DISPLAY_PROPERTIES"]["FOR"]["DISPLAY_VALUE"][] = "<a href=\"" . str_replace("#FOR_ID#",
                                    $arResult["DISPLAY_PROPERTIES"]["FOR"]["VALUE_ENUM_ID"][$keyFor],
                                    $arParams["~FOR_URL"]) . "\" title=\"" . $forName . "\">" . $forName . "</a>";
    }

    $arResult["DISPLAY_PROPERTIES"]["FOR"]["DISPLAY_VALUE"] = implode(", ", $arResult["DISPLAY_PROPERTIES"]["FOR"]["DISPLAY_VALUE"]);
}

$arResult["DISPLAY_PROPERTIES"]['DOCUMENTS_FILES']["DISPLAY_VALUE"] = array();
if (count($arResult["DISPLAY_PROPERTIES"]['DOCUMENTS_FILES']["VALUE"]) > 1)
{
    foreach ($arResult["DISPLAY_PROPERTIES"]['DOCUMENTS_FILES']["FILE_VALUE"] as $value)
    {
        $arResult["DISPLAY_PROPERTIES"]['DOCUMENTS_FILES']["DISPLAY_VALUE"][] = "<a href=\"/bitrix/redirect.php?event1=file&event2=download&event3=" . $value['FILE_NAME'] . "&goto=" . $value['SRC'] . "\">" . $value["DESCRIPTION"] . "</a> (" . pathinfo($value['SRC'], PATHINFO_EXTENSION) . ", " . Bitrix\GosSite\Tools::readableFileSize($value["FILE_SIZE"]) . ")";
    }
}
else
{
    $arResult["DISPLAY_PROPERTIES"]['DOCUMENTS_FILES']["DISPLAY_VALUE"][] = "<a href=\"/bitrix/redirect.php?event1=file&event2=download&event3=" . $value['FILE_NAME'] . "&goto=" . $value['SRC'] . "\">" . $arResult["DISPLAY_PROPERTIES"]['DOCUMENTS_FILES']["FILE_VALUE"]["DESCRIPTION"] . "</a>";
}