<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
define('WORK_DIR',__DIR__);$APPLICATION->SetPageProperty("show_timestamp_x", "N");
require_once(WORK_DIR.'/addToSelected.php');?>


<blockquote><b>Публикуется</b> информация о размещении заказов на поставки товаров, выполнение работ, оказание услуг для государственных и муниципальных нужд в соответствии с законодательством Российской Федерации о размещении заказов на поставки товаров, выполнение работ, оказание услуг для государственных и муниципальных нужд;</blockquote>

<br />
<?if($_REQUEST['selected']=="Y")
{
	$APPLICATION->AddChainItem("Избранное", "");
	$APPLICATION->SetTitle("Гос. закупки - Избранное");$APPLICATION->SetPageProperty("show_timestamp_x", "N");	
	$munOrderSelected = $APPLICATION->get_cookie("munOrderSelected");	
	$GLOBALS['arrFilter']=array("ID"=>explode(";",$munOrderSelected));
	if($munOrderSelected)
	{?>
		<p id="clearSelected"><a href="addToSelected.php?clear=all" rel="nofollow">Очистить Избранное</a></p>	
<?	}	
}
else
{
	$APPLICATION->SetTitle("Гос. закупки");$APPLICATION->SetPageProperty("show_timestamp_x", "N");
	$GLOBALS['arrFilter']=array();
}?>
<br />
<?if(!$munOrderSelected && $_REQUEST['selected']=="Y"):?>
	<p>В избранное ничего не добавлено</p>
<?else:?>

<?$APPLICATION->IncludeComponent(
	"bitrix:news",
	"munorder",
	Array(
		"IBLOCK_TYPE" => "orders",
		"IBLOCK_ID" => "#ORDERS_IBLOCK_ID#",
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
		"CHECK_DATES" => "N",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "#SITE_DIR#program/mun-order/",
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
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "Y",
		"USE_PERMISSIONS" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(),
		"LIST_PROPERTY_CODE" => array(0=>"",1=>"",),
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"DISPLAY_NAME" => "Y",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y H:i",
		"DETAIL_FIELD_CODE" => array(0 => "SHOW_COUNTER",
		1 => "DATE_CREATE",
		2 => "TIMESTAMP_X",),
		"DETAIL_PROPERTY_CODE" => array(0=>"CUSTOMER",1=>"FIN_SOURCE",2=>"GOODS",3=>"COTIR_SEND",4=>"PAYMENT",5=>"CONTRACT",6=>"VIEW_STATE",7=>"OPEN_DATE",8=>"DOC_PAYMENT",9=>"CONTEST_DOC",10=>"ENDS",11=>"MUN_CONTRACT",12=>"AUCT_DOCS",13=>"AUCT_DOC_PAYMENT",14=>"AUCT_DATA",15=>"ORGS_BENEFITS",16=>"",),
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_PAGER_TITLE" => "Страница",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SEF_URL_TEMPLATES" => Array(
			"news" => "",
			"section" => "#SECTION_ID#/",
			"detail" => "#SECTION_ID#/#ELEMENT_ID#/",
			"search" => "search/",
			"rss" => "rss/",
			"rss_section" => "#SECTION_ID#/rss/"
		),
		"VARIABLE_ALIASES" => Array(
			"news" => Array(),
			"section" => Array(),
			"detail" => Array(),
			"search" => Array(),
			"rss" => Array(),
			"rss_section" => Array(),
		)
	)
);?><?endif?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>