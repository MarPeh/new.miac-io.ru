<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Объекты области");
?> 
<?if(empty($_REQUEST["ID"])){
    LocalRedirect("#GID_BACK_URL#/turizm/");
}?>
<?$APPLICATION->IncludeComponent("bitrix:news.detail", "gid_detail", array(
	"IBLOCK_TYPE" => "guide_map",
	"IBLOCK_ID" => "#GID_OBJECTS_IBLOCK#",
	"ELEMENT_ID" => $_REQUEST["ID"],
	"ELEMENT_CODE" => "",
	"CHECK_DATES" => "N",
	"FIELD_CODE" => array(
		0 => "DATE_ACTIVE_FROM",
		1 => "ACTIVE_FROM",
		2 => "DATE_ACTIVE_TO",
		3 => "ACTIVE_TO",
		4 => "",
	),
	"PROPERTY_CODE" => array(
		0 => "ADDRESS",
		1 => "OPENING",
		2 => "LINK",
		3 => "",
	),
	"IBLOCK_URL" => "",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000000",
	"CACHE_GROUPS" => "Y",
	"META_KEYWORDS" => "-",
	"META_DESCRIPTION" => "-",
	"BROWSER_TITLE" => "-",
	"SET_TITLE" => "Y",
	"SET_STATUS_404" => "N",
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
	"ADD_SECTIONS_CHAIN" => "Y",
	"ACTIVE_DATE_FORMAT" => "d.m.Y",
	"USE_PERMISSIONS" => "N",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Страница",
	"PAGER_TEMPLATE" => "",
	"PAGER_SHOW_ALL" => "Y",
	"DISPLAY_DATE" => "Y",
	"DISPLAY_NAME" => "Y",
	"DISPLAY_PICTURE" => "Y",
	"DISPLAY_PREVIEW_TEXT" => "Y",
	"USE_SHARE" => "N",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>