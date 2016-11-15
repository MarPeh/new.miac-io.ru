<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("no_wrapper", "Y");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Добро пожаловать");
?>
<? if (CModule::IncludeModule("iblock")) { ?>
    <div class="double-header-block clearfix col-margin-bottom">
        <h2 class="double-header">Госуслуги</h2>
        <div class="double-header-link"><a href="#SITE_DIR#gosserv/">Все услуги<i class="icon icon-arrow-right"></i></a></div>
    </div>
    <div class="tts-tabs col-margin-bottom">
        <div class="tts-tabs-switchers-wrapper">
            <ul class="tts-tabs-switchers">
                <?
                $rsRecipientTypes = CIBlockPropertyEnum::GetList(Array("id" => "asc"),
                    array("IBLOCK_ID" => "#DEPART_IBLOCK_ID#", "CODE" => "FOR"));

                $i = 0;
                $typesList = array();

                while ($arRecipientType = $rsRecipientTypes->GetNext()) {
                    $typesList[] = $arRecipientType["ID"];
                    ?>
                    <li class="tts-tabs-switcher<? echo ($i++ == 0) ? " active" : "" ?>" data-target-self="#SITE_DIR#gosserv/for/<? echo $arRecipientType['ID'] ?>/"><? echo $arRecipientType['VALUE'] ?></li>
                    <?
                }
                ?>
            </ul>
        </div>
        <? foreach ($typesList as $i => $typeId) { ?>
            <div class="tts-tabs-item padding-box<? echo ($i == 0) ? " active" : "" ?>">
                <?
                $GLOBALS['CATEGORY_FILTER'] = Bitrix\GosSite\Tools::getServicesCatsFilter("#GOSSERV_IBLOCK_ID#", $typeId);

                $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "services-category",
                    Array(
                        "IBLOCK_TYPE" => "gosserv",
                        "IBLOCK_ID" => "#GOSSERV_IBLOCK_ID#",
                        "NEWS_COUNT" => "2000",
                        "SORT_BY1" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "SORT_BY2" => "NAME",
                        "SORT_ORDER2" => "ASC",
                        "FILTER_NAME" => "CATEGORY_FILTER",
                        "FIELD_CODE" => array(0=>"",1=>"",),
                        "PROPERTY_CODE" => array(0=>"",1=>"picture",2=>"",),
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "#SITE_DIR#gosserv/for/".$typeId."/category/#ELEMENT_ID#/",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "SET_TITLE" => "N",
                        "SET_STATUS_404" => "N",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "ADD_SECTIONS_CHAIN" => "Y",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "DISPLAY_TOP_PAGER" => "N",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "PAGER_TITLE" => "Новости",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => "",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "DISPLAY_DATE" => "N",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "N",
                        "DISPLAY_PREVIEW_TEXT" => "N",
                        "AJAX_OPTION_ADDITIONAL" => ""
                    ),
                    false,
                    array("HIDE_ICONS" => "Y")
                );
                ?>
            </div>
        <? } ?>
    </div>
<? } ?>

    <div class="col-margin white-box padding-box">
        <div class="content">
            <div class="col col-mb-12 col-4">
                <div class="h2 mt0">Обращения</div>
                <a class="btn" href="#SITE_DIR#feedback/new.php">Задать вопрос</a>
            </div>
            <div class="col col-mb-12 col-4">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    ".default",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "#SITE_DIR#includes/home-feedback-text1.php",
                        "COMPONENT_TEMPLATE" => ".default"
                    ),
                    false
                );?>
            </div>
            <div class="col col-mb-12 col-4">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    ".default",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "#SITE_DIR#includes/home-feedback-text2.php",
                        "COMPONENT_TEMPLATE" => ".default"
                    ),
                    false
                );?>
            </div>
        </div>
    </div>


<?$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "home-news",
    array(
        "COMPONENT_TEMPLATE" => "home-news",
        "IBLOCK_TYPE" => "news",
        "IBLOCK_ID" => "#NEWS_IBLOCK_ID#",
        "NEWS_COUNT" => "5",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "FILTER_NAME" => "",
        "FIELD_CODE" => array(
            0 => "DETAIL_PICTURE",
            1 => "",
        ),
        "PROPERTY_CODE" => array(
            0 => "",
            1 => "",
        ),
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "N",
        "PREVIEW_TRUNCATE_LEN" => "",
        "ACTIVE_DATE_FORMAT" => "j F Y",
        "SET_TITLE" => "N",
        "SET_BROWSER_TITLE" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_LAST_MODIFIED" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "INCLUDE_SUBSECTIONS" => "N",
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "N",
        "DISPLAY_PICTURE" => "N",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "PAGER_TEMPLATE" => ".default",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Новости",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "N",
        "MESSAGE_404" => ""
    ),
    false
);?>

<?$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "external-resources",
    array(
        "COMPONENT_TEMPLATE" => "external-resources",
        "IBLOCK_TYPE" => "information",
        "IBLOCK_ID" => "#EXTERNAL_IBLOCK_ID#",
        "NEWS_COUNT" => "9",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_ORDER1" => "DESC",
        "SORT_BY2" => "SORT",
        "SORT_ORDER2" => "ASC",
        "FILTER_NAME" => "",
        "FIELD_CODE" => array(
            0 => "DETAIL_PICTURE",
            1 => "",
        ),
        "PROPERTY_CODE" => array(
            0 => "LINK",
            1 => "",
        ),
        "CHECK_DATES" => "Y",
        "DETAIL_URL" => "",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_STYLE" => "Y",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "36000000",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "N",
        "PREVIEW_TRUNCATE_LEN" => "",
        "ACTIVE_DATE_FORMAT" => "j F Y",
        "SET_TITLE" => "N",
        "SET_BROWSER_TITLE" => "N",
        "SET_META_KEYWORDS" => "N",
        "SET_META_DESCRIPTION" => "N",
        "SET_LAST_MODIFIED" => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "INCLUDE_SUBSECTIONS" => "N",
        "DISPLAY_DATE" => "N",
        "DISPLAY_NAME" => "N",
        "DISPLAY_PICTURE" => "N",
        "DISPLAY_PREVIEW_TEXT" => "N",
        "PAGER_TEMPLATE" => ".default",
        "DISPLAY_TOP_PAGER" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "PAGER_TITLE" => "Новости",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "SET_STATUS_404" => "N",
        "SHOW_404" => "N",
        "MESSAGE_404" => ""
    ),
    false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>