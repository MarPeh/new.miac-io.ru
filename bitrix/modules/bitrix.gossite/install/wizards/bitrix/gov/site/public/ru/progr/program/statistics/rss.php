<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:rss.out",
	"",
	Array(
		"IBLOCK_TYPE" => "visits",
		"IBLOCK_ID" => "#VISITS_IBLOCK_ID#",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"NUM_NEWS" => "20",
		"NUM_DAYS" => "30",
		"RSS_TTL" => "60",
		"YANDEX" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_NOTES" => "",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y"
	),
false,
array("HIDE_ICONS"=>"Y")
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>