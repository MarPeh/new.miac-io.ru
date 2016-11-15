<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Видеогалерея");$APPLICATION->SetPageProperty("show_timestamp_x", "N");
?><?$APPLICATION->IncludeComponent(
	"bitrix:iblock.tv",
	"",
	Array(
		"DEFAULT_SMALL_IMAGE" => "/bitrix/components/bitrix/iblock.tv/templates/.default/images/default_small.png",
		"DEFAULT_BIG_IMAGE" => "/bitrix/components/bitrix/iblock.tv/templates/.default/images/default_big.png",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"IBLOCK_TYPE" => "photovideogallery",
		"IBLOCK_ID" => "#VIDEOGALLERY_IBLOCK_ID#",
		"ALLOW_SWF" => "N",
		"DISPLAY_PANEL" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"PATH_TO_FILE" => "#VIDEOGALLERY_PFILE_ID#",
		"DURATION" => "#VIDEOGALLERY_PDURATION_ID#",
		"WIDTH" => "400",
		"HEIGHT" => "300",
		"LOGO" => "/bitrix/components/bitrix/iblock.tv/templates/.default/images/logo.png",
	),
false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>