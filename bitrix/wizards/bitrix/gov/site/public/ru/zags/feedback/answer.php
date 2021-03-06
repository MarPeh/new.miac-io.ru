<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обращения граждан");?>
	<p>
		<?$APPLICATION->IncludeComponent(
			"bitrix:news",
			"list",
			Array(
				"DISPLAY_DATE" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"SEF_MODE" => "N",
				"AJAX_MODE" => "N",
				"IBLOCK_TYPE" => "feedback",
				"IBLOCK_ID" => "#FAQ_IBLOCK_ID#",
				"NEWS_COUNT" => "20",
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
				"PREVIEW_TRUNCATE_LEN" => "",
				"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
				"LIST_FIELD_CODE" => array(),
				"LIST_PROPERTY_CODE" => array(),
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"DISPLAY_NAME" => "Y",
				"META_KEYWORDS" => "-",
				"META_DESCRIPTION" => "-",
				"BROWSER_TITLE" => "-",
				"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
				"DETAIL_FIELD_CODE" => array(0 => "SHOW_COUNTER",
				                             1 => "DATE_CREATE",
				                             2 => "TIMESTAMP_X",),
				"DETAIL_PROPERTY_CODE" => array(),
				"DETAIL_DISPLAY_TOP_PAGER" => "N",
				"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
				"DETAIL_PAGER_TITLE" => "Страница",
				"DETAIL_PAGER_TEMPLATE" => "",
				"DETAIL_PAGER_SHOW_ALL" => "Y",
				"DISPLAY_PANEL" => "N",
				"SET_TITLE" => "N",
				"SET_STATUS_404" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "Y",
				"USE_PERMISSIONS" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "3600",
				"CACHE_FILTER" => "N",
				"CACHE_GROUPS" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => "",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "Y",
				"VARIABLE_ALIASES" => Array(
					"SECTION_ID" => "SECTION_ID",
					"ELEMENT_ID" => "ELEMENT_ID"
				),
				"AJAX_OPTION_SHADOW" => "Y",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => ""
			)
		);?></p>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>