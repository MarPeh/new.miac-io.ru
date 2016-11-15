<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arSectionsNames = array();
if (!empty($arResult["IBLOCK_SECTION_ID"])) {
    $arSection                = GetIBlockSection($arResult["IBLOCK_SECTION_ID"]);
    $arResult["SECTION_NAME"] = $arSection["NAME"];
} else {
    $arResult["SECTION_NAME"] = "";
}

$dbVideo = CIBlockElement::GetProperty($arResult["IBLOCK_ID"], $arResult["ID"], array("sort" => "asc"),
    Array("CODE" => "VIDEO"));
$arVideo = $dbVideo->GetNext();

if (!empty($arVideo['VALUE'])) {
    $arVideo = GetIBlockElement($arVideo['VALUE']);

    if (!empty($arVideo['PROPERTIES']['FILE']['VALUE'])) {
        $arResult['MEDIA_VIDEO'] = $arVideo['PROPERTIES']['FILE']['VALUE'];
    }
}

$dbPhoto = CIBlockElement::GetProperty($arResult["IBLOCK_ID"], $arResult["ID"], array("sort" => "asc"),
    Array("CODE" => "PHOTOGALLERY"));
$arPhoto = $dbPhoto->GetNext();

if (!empty($arPhoto['VALUE'])) {
    $arPhoto = GetIBlockSection($arPhoto['VALUE']);

    if (!empty($arPhoto['ID'])) {
        $arResult['MEDIA_PHOTO']        = $arPhoto['ID'];
        $arResult['MEDIA_PHOTO_IBLOCK'] = $arPhoto['IBLOCK_ID'];
        $arResult['MEDIA_PHOTO_URL']    = $arPhoto['LIST_PAGE_URL'];
    }
}

foreach ($arResult["DISPLAY_PROPERTIES"] as $property) {
    if ($property["PROPERTY_TYPE"] === "F") {
        if (is_array($property["DISPLAY_VALUE"])) {
            $arItem["DISPLAY_PROPERTIES"][$property["CODE"]]["DISPLAY_VALUE"] = array();
            foreach ($property["FILE_VALUE"] as $value) {
                $arItem["DISPLAY_PROPERTIES"][$property["CODE"]]["DISPLAY_VALUE"][] = "<a href=\"" . $value["SRC"] . "\">" . $value["ORIGINAL_NAME"] . "</a> (" . Bitrix\Gossite\Tools::readableFileSize($value["FILE_SIZE"]) . ")";
            }
        } else {
            $arItem["DISPLAY_PROPERTIES"][$property["CODE"]]["DISPLAY_VALUE"] = "<a href=\"" . $property["FILE_VALUE"]["SRC"] . "\">" . $property["FILE_VALUE"]["ORIGINAL_NAME"] . "</a> (" . Bitrix\Gossite\Tools::readableFileSize($property["FILE_VALUE"]["FILE_SIZE"]) . ")";
        }
    }
}

$arResult["BACK_BTN_TITLE"] = str_replace("[".SITE_ID."]", "", $arResult["IBLOCK"]['NAME']);