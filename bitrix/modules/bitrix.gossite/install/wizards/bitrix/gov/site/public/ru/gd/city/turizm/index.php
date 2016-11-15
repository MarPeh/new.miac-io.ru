<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Объекты области");
?>
<?
if (\Bitrix\Main\ModuleManager::isModuleInstalled('bitrix.map')) {
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:map.map",
	"modern",
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADDRESS_PROP_CODE" => "ADDRESS",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "modern",
		"DATA_TYPE" => "objects",
		"DESCRIPTION_PROP_CODE" => "",
		"DETAIL_URL" => "#GID_DETAIL_URL#",
		"EMAIL_PROP_CODE" => "",
		"FILTER_NAME" => "",
		"IBLOCK_ID" => "#GID_OBJECTS_IBLOCK#",
		"IBLOCK_TYPE" => "guide_map",
		"ICONPOS_PROP_CODE" => "UF_ICON_POS",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"LATITUDE_PROP_CODE" => "LAT",
		"LINK_PROP_CODE" => "LINK",
		"LONGITUDE_PROP_CODE" => "LNG",
		"MAP_HEIGHT" => "550",
		"MAP_NARROW_WIDTH" => "900",
		"MAP_TYPE" => "yandex",
		"NAME_PROP_CODE" => "",
		"NO_CATS" => "N",
		"NO_CAT_ICONS" => "N",
		"OLD_DATA_MODE" => "N",
		"OPENING_PROP_CODE" => "OPENING",
		"PARENT_PROP_CODE" => "PARENT",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PHONE_PROP_CODE" => "PHONE",
		"PICTURE_PROP_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"QUERY_OBJECTS" => "",
		"QUERY_SECTION" => "",
		"REPLACE_RULES" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "NAME",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"SORT_SECTIONS_BY1" => "NAME",
		"SORT_SECTIONS_BY2" => "SORT",
		"SORT_SECTIONS_ORDER1" => "DESC",
		"SORT_SECTIONS_ORDER2" => "ASC",
		"UNIVERSAL_MARKER" => "N",
		"AJAX_PATH" => "/bitrix/components/bitrix/map.map/ajax.php",
		"TITLE_MAP" => "",
		"LOAD_ITEMS" => "N",
		"FULLSCREEN_SLIDE" => "N",
		"FULLSCREEN_SHOW" => "N",
		"CUSTOM_VIEW" => "N"
	),
	false
);?>
<?
} else {
?>
    <?if ($USER->IsAdmin()) { ?>
        <div class="alert mb20">Для функционирования данного раздела необходимо установить модуль <a href="http://marketplace.1c-bitrix.ru/solutions/bitrix.map/">"1С-Битрикс: Интерактивная карта объектов"</a></div>
    <? } ?>
    <p><b>Раздел на реконструкции.</b></p>
    <p>В ближайшее время мы обновим информацию об объектах  и  событиях города.</p>
    <p>Приносим извинения за неудобства.</p>
<?
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>