<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Видеогалерея");$APPLICATION->SetPageProperty("show_timestamp_x", "N");
?><?$APPLICATION->IncludeComponent("bitrix:iblock.tv", ".default", array(
	"IBLOCK_TYPE" => "photovideogallery",
	"IBLOCK_ID" => "2",
	"ALLOW_SWF" => "N",
	"DISPLAY_PANEL" => "Y",
	"PATH_TO_FILE" => "4",
	"DURATION" => "5",
	"WIDTH" => "400",
	"HEIGHT" => "300",
	"LOGO" => "/bitrix/components/bitrix/iblock.tv/templates/.default/images/logo.png",
	"SECTION_ID" => "",
	"SHOW_COUNTER_EVENT" => "N",
	"STAT_EVENT" => "N",
	"DEFAULT_SMALL_IMAGE" => "/bitrix/components/bitrix/iblock.tv/templates/.default/images/default_small.png",
	"DEFAULT_BIG_IMAGE" => "/bitrix/components/bitrix/iblock.tv/templates/.default/images/default_big.png",
	"SORT_BY1" => "ACTIVE_FROM",
	"SORT_ORDER1" => "DESC",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"CACHE_GROUPS" => "Y"
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>