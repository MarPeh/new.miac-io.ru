<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (empty($arResult["SECTION_URL"])) {
    if (!empty($arResult["IBLOCK_SECTION_ID"])) {
        $arResult["SECTION_URL"] = str_replace(array('#SITE_DIR#', '#SECTION_ID#'), array(SITE_DIR, $arResult["IBLOCK_SECTION_ID"]), $arResult["IBLOCK"]["SECTION_PAGE_URL"]);
    } else {
        $arResult["SECTION_URL"] = $arResult["IBLOCK"]["LIST_PAGE_URL"];
    }
}
