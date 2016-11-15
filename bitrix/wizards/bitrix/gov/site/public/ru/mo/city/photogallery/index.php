<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");$APPLICATION->SetPageProperty("show_timestamp_x", "N");
?>
<a style="float:right;position:relative;z-index:1;" href="#SITE_DIR#city/photogallery/rss.php" title="RSS"><img width="14px" height="14px" alt="rss" src="#SITE_DIR#images/icon_rss.png"/></a>
<?$APPLICATION->IncludeComponent("bitrix:photogallery", ".default", array(
	"USE_LIGHT_VIEW" => "Y",
	"IBLOCK_TYPE" => "photovideogallery",
	"IBLOCK_ID" => "#PHOTOGALLERY_IBLOCK_ID#",
	"SEF_MODE" => "Y",
	"SEF_FOLDER" => "#SITE_DIR#city/photogallery/",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"USE_RATING" => "N",
	"SHOW_TAGS" => "N",
	"USE_COMMENTS" => "N",
	"SHOW_LINK_ON_MAIN_PAGE" => array(
		0 => "id",
		1 => "shows",
		2 => "rating",
		3 => "comments",
	),
	"SHOW_ON_MAIN_PAGE" => "none",
	"SHOW_ON_MAIN_PAGE_POSITION" => "right",
	"SHOW_ON_MAIN_PAGE_TYPE" => "none",
	"SHOW_ON_MAIN_PAGE_COUNT" => "",
	"SHOW_PHOTO_ON_DETAIL_LIST" => "show_count",
	"SHOW_PHOTO_ON_DETAIL_LIST_COUNT" => "500",
	"PAGE_NAVIGATION_TEMPLATE" => "",
	"WATERMARK_COLORS" => array(
		0 => "FF0000",
		1 => "FFFF00",
		2 => "FFFFFF",
		3 => "000000",
		4 => "",
	),
	"TEMPLATE_LIST" => ".default",
	"CELL_COUNT" => "0",
	"SEF_URL_TEMPLATES" => array(
		"sections_top" => "",
		"section" => "#SECTION_ID#/",
		"section_edit" => "#SECTION_ID#/action/#ACTION#/",
		"section_edit_icon" => "#SECTION_ID#/icon/action/#ACTION#/",
		"upload" => "#SECTION_ID#/action/upload/",
		"detail" => "#SECTION_ID#/#ELEMENT_ID#/",
		"detail_slide_show" => "#SECTION_ID#/#ELEMENT_ID#/slide_show/",
		"detail_list" => "#SECTION_ID#/#ELEMENT_ID#/list/",
		"detail_edit" => "#SECTION_ID#/#ELEMENT_ID#/action/#ACTION#/",
	)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>