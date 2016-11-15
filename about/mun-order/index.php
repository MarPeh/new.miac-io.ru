<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
require_once(__DIR__.'/addToSelected.php');?>

	<blockquote><b>Публикуется</b> информация о размещении заказов на поставки товаров, выполнение работ, оказание услуг для государственных и муниципальных нужд в соответствии с законодательством Российской Федерации о размещении заказов на поставки товаров, выполнение работ, оказание услуг для государственных и муниципальных нужд;</blockquote>

	<br />
<?
if ($_REQUEST['selected'] == "Y") {
	$APPLICATION->AddChainItem("Избранное", "");
	$APPLICATION->SetTitle("Конкурсы - Избранное");
	$munOrderSelected     = $APPLICATION->get_cookie("munOrderSelected");
	$GLOBALS['arrFilter'] = array("ID" => explode(";", $munOrderSelected));
	if (!$munOrderSelected) {
		$GLOBALS['arrFilter'] = array("ID" => "-1");
	}
} else {
	$APPLICATION->SetTitle("Конкурсы");
	$GLOBALS['arrFilter'] = array();
}
?>
	<br />

<?$APPLICATION->IncludeComponent("bitrix:news", "munorder", array(
	"IBLOCK_TYPE" => "orders",
	"IBLOCK_ID" => "16",
	"NEWS_COUNT" => "10",
	"USE_SEARCH" => "N",
	"USE_RSS" => "Y",
	"NUM_NEWS" => "20",
	"NUM_DAYS" => "0",
	"YANDEX" => "N",
	"USE_RATING" => "N",
	"USE_CATEGORIES" => "N",
	"USE_REVIEW" => "N",
	"USE_FILTER" => "Y",
	"SORT_BY1" => "ACTIVE_FROM",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "SORT",
	"SORT_ORDER2" => "ASC",
	"CHECK_DATES" => "N",
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "/about/mun-order/",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_SHADOW" => "Y",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "300",
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
		0 => "ABOUT_ORDER",
		1 => "",
	),
	"HIDE_LINK_WHEN_NO_DETAIL" => "N",
	"DISPLAY_NAME" => "Y",
	"META_KEYWORDS" => "-",
	"META_DESCRIPTION" => "-",
	"BROWSER_TITLE" => "-",
	"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y H:i",
	"DETAIL_FIELD_CODE" => array(
		1 => "DATE_CREATE",
		2 => "TIMESTAMP_X",
	),
	"DETAIL_PROPERTY_CODE" => array(
		0 => "CUSTOMER",
		1 => "FIN_SOURCE",
		2 => "GOODS",
		3 => "COTIR_SEND",
		4 => "PAYMENT",
		5 => "CONTRACT",
		6 => "VIEW_STATE",
		7 => "OPEN_DATE",
		8 => "DOC_PAYMENT",
		9 => "CONTEST_DOC",
		10 => "ENDS",
		11 => "ABOUT_ORDER",
		12 => "ORG_ORDERS",
		13 => "END_ORDERS",
		14 => "PRIZE_ORDERS",
		15 => "ADRESS_ORDERS",
		16 => "MUN_CONTRACT",
		17 => "AUCT_DOCS",
		18 => "AUCT_DOC_PAYMENT",
		19 => "AUCT_DATA",
		20 => "ORGS_BENEFITS",
		21 => "[DOCS_ORDER]",
		22 => "",
	),
	"DETAIL_DISPLAY_TOP_PAGER" => "N",
	"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
	"DETAIL_PAGER_TITLE" => "Страница",
	"DETAIL_PAGER_TEMPLATE" => "",
	"DETAIL_PAGER_SHOW_ALL" => "Y",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600",
	"PAGER_SHOW_ALL" => "Y",
	"DISPLAY_DATE" => "Y",
	"DISPLAY_PICTURE" => "Y",
	"DISPLAY_PREVIEW_TEXT" => "Y",
	"AJAX_OPTION_ADDITIONAL" => "",
	"SEF_URL_TEMPLATES" => array(
		"news" => "",
		"section" => "#SECTION_ID#/",
		"detail" => "#SECTION_ID#/#ELEMENT_ID#/",
		"search" => "search/",
		"rss" => "rss/",
		"rss_section" => "#SECTION_ID#/rss/",
	)
),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>