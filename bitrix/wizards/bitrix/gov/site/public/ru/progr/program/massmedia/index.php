<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новости");$APPLICATION->SetPageProperty("show_timestamp_x", "N");
?>
<blockquote><b>Публикуются</b>: Сведения о средствах массовой информации, учрежденных государственным органом, органом местного самоуправления (при наличии);</blockquote>

<br />

<br />

<?$APPLICATION->IncludeComponent("bitrix:news", "list", array(
	"IBLOCK_TYPE" => "massmedia",
	"IBLOCK_ID" => "#MASSMEDIA_IBLOCK_ID#",
	"NEWS_COUNT" => "10",
	"USE_SEARCH" => "N",
	"USE_RSS" => "Y",
	"NUM_NEWS" => "20",
	"NUM_DAYS" => "0",
	"YANDEX" => "N",
	"USE_RATING" => "N",
	"USE_CATEGORIES" => "N",
	"USE_REVIEW" => "N",
	"USE_FILTER" => "N",
	"SORT_BY1" => "ACTIVE_FROM",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "SORT",
	"SORT_ORDER2" => "ASC",
	"CHECK_DATES" => "Y",
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "#SITE_DIR#program/massmedia/",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_SHADOW" => "Y",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"CACHE_FILTER" => "N",
	"DISPLAY_PANEL" => "N",
	"SET_TITLE" => "Y",
	"SET_STATUS_404" => "N",
	"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
	"ADD_SECTIONS_CHAIN" => "Y",
	"USE_PERMISSIONS" => "N",
	"PREVIEW_TRUNCATE_LEN" => "",
	"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
	"LIST_FIELD_CODE" => array(
		
	),
	"LIST_PROPERTY_CODE" => array(
		0 => "TIRASH",
		1 => "",
	),
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"DISPLAY_NAME" => "N",
	"META_KEYWORDS" => "-",
	"META_DESCRIPTION" => "-",
	"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
	"DETAIL_FIELD_CODE" => array(
		0 => "",
		1 => "DATA",
		2 => "TIRASH",
		3 => "SHOW_COUNTER",
		4 => "DATE_CREATE",
		5 => "TIMESTAMP_X",
	),
	"DETAIL_PROPERTY_CODE" => array(
		0 => "TIRASH",
		1 => "",
	),
	"DETAIL_DISPLAY_TOP_PAGER" => "N",
	"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
	"DETAIL_PAGER_TITLE" => "Страница",
	"DETAIL_PAGER_TEMPLATE" => "",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Учрежденные СМИ",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "Y",
	"DISPLAY_DATE" => "N",
	"DISPLAY_PICTURE" => "Y",
	"DISPLAY_PREVIEW_TEXT" => "Y",
	"AJAX_OPTION_ADDITIONAL" => "",
	"SEF_URL_TEMPLATES" => array(
		"news" => "",
		"section" => "",
		"detail" => "#ELEMENT_ID#/",
		"search" => "search/",
		"rss" => "rss/",
		"rss_section" => "#SECTION_ID#/rss/",
	)
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>