<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Государственные услуги");
$APPLICATION->SetPageProperty("no_wrapper", "Y");
?>

<?
if(CModule::IncludeModule("iblock")) {
    $_REQUEST["MODE"]       = htmlspecialcharsbx($_REQUEST["MODE"]);
    $_REQUEST["FOR"]        = (int)$_REQUEST["FOR"];
    $_REQUEST["ELEMENT_ID"] = (int)$_REQUEST["ELEMENT_ID"];
    $_REQUEST["SECTION_ID"] = (int)$_REQUEST["SECTION_ID"];

    if ($_REQUEST["MODE"] !== "vedomstva" && $_REQUEST["MODE"] !== "allservice") {
        $_REQUEST["MODE"] = "category";
    }

    if ($_REQUEST["ELEMENT_ID"] > 0) {

        $APPLICATION->IncludeComponent("bitrix:news.detail", "service-detail", array(
            "IBLOCK_TYPE" => "gosserv",
            "IBLOCK_ID" => "10",
            "ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
            "ELEMENT_CODE" => "",
            "CHECK_DATES" => "Y",
            "FIELD_CODE" => array(
                0 => "SHOW_COUNTER",
                1 => "DATE_CREATE",
                2 => "TIMESTAMP_X",
            ),
            "PROPERTY_CODE" => array(
                0 => "DOCUMENTS_TEXT",
                1 => "FOR",
                2 => "AKT",
                3 => "RESULT",
                4 => "ADRESS",
                5 => "GRAFIK",
                6 => "PROCEDURE",
                7 => "OTKAZ",
                8 => "OBGALOVANIE",
                9 => "SROK",
                10 => "PAYMENT",
                11 => "DOCUMENTS_FILES",
                12 => "",
            ),
            "IBLOCK_URL" => "/gosserv/for/".$_REQUEST["FOR"]."/vedomstva/#SECTION_ID#/",
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
            "ADD_SECTIONS_CHAIN" => "N",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "USE_PERMISSIONS" => "N",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "PAGER_TITLE" => "Страница",
            "PAGER_TEMPLATE" => "",
            "PAGER_SHOW_ALL" => "N",
            "DISPLAY_DATE" => "N",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "USE_SHARE" => "N",
            "FOR_URL" => "/gosserv/for/#FOR_ID#/",
            "MAIN_INFO_URL" => "/gosserv/for/".$_REQUEST["FOR"]."/".$_REQUEST["MODE"]."/".$_REQUEST["SECTION_ID"]."/#ELEMENT_ID#/",
            "CURRENT_PROPERTY" => $_REQUEST["PROPERTY"],
            "AJAX_OPTION_ADDITIONAL" => ""
        ),
            false
        );
    } else {
        ?>
        <div class="tts-tabs col-margin-bottom">
            <div class="tts-tabs-switchers-wrapper">
                <ul class="tts-tabs-switchers">
                    <?
                    $rsRecipientTypes = CIBlockPropertyEnum::GetList(Array("id" => "asc"),
                        array("IBLOCK_ID" => "10", "CODE" => "FOR"));

                    $i = 0;

                    while ($arRecipientType = $rsRecipientTypes->GetNext()) {
                        if ($i++ === 0 && empty($_REQUEST["FOR"])) {
                            $_REQUEST["FOR"] = $arRecipientType['ID'];
                        }
                        ?>
                        <li class="tts-tabs-switcher<? echo ($_REQUEST['FOR'] == $arRecipientType['ID']) ? " active" : "" ?>" data-target-self="/gosserv/for/<? echo $arRecipientType['ID'] ?>/"><? echo $arRecipientType['VALUE'] ?></li><?
                    }
                    ?>
                </ul>
            </div>
            <div class="tts-tabs-item padding-box active">
                <div class="btn-group col-margin-bottom">
                    <?
                    $modeList = array(
                        "category" => "По категориям",
                        "vedomstva" => "По ведомствам",
                        "allservice" => "Все услуги"
                    );

                    foreach ($modeList as $code => $caption) {
                        ?>
                        <a class="btn btn-outline btn-square<?echo $_REQUEST["MODE"] == $code ? " active" : "" ?>" href="/gosserv/for/<?echo $_REQUEST["FOR"] ?>/<?echo $code ?>/"><?echo $caption?></a>
                        <?
                    }
                    ?>
                </div>


                <?
                $GLOBALS['CATEGORY_FILTER'] = array("PROPERTY_FOR" => $_REQUEST["FOR"]);
                if ($_REQUEST["MODE"] === 'category') {
                    $GLOBALS['CATEGORY_FILTER']['PROPERTY_CATEGORY1'] = $_REQUEST["SECTION_ID"];
                } elseif ($_REQUEST["MODE"] === 'vedomstva') {
                    $GLOBALS['CATEGORY_FILTER']['SECTION_ID']          = $_REQUEST["SECTION_ID"];
                    $GLOBALS['CATEGORY_FILTER']['INCLUDE_SUBSECTIONS'] = "Y";
                }

                if($_REQUEST["MODE"] === "category" && empty($_REQUEST["SECTION_ID"])) {
                    $GLOBALS['CATEGORY_FILTER'] = Bitrix\GosSite\Tools::getServicesCatsFilter($_REQUEST["FOR"]);

                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "services-category",
                        Array(
                            "IBLOCK_TYPE" => "gosserv",
                            "IBLOCK_ID" => "9",
                            "NEWS_COUNT" => "2000",
                            "SORT_BY1" => "SORT",
                            "SORT_ORDER1" => "ASC",
                            "SORT_BY2" => "NAME",
                            "SORT_ORDER2" => "ASC",
                            "FILTER_NAME" => "CATEGORY_FILTER",
                            "FIELD_CODE" => array(0=>"",1=>"",),
                            "PROPERTY_CODE" => array(0=>"",1=>"picture",2=>"",),
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "/gosserv/for/".$_REQUEST["FOR"]."/category/#ELEMENT_ID#/",
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
                } elseif ($_REQUEST["MODE"] === "vedomstva" && empty($_REQUEST["SECTION_ID"])) {
                    $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "services-department", array(
                        "IBLOCK_TYPE" => "gosserv",
                        "IBLOCK_ID" => "10",
                        "SECTION_ID" => $_REQUEST["SECTION_ID"],
                        "SECTION_CODE" => "",
                        "COUNT_ELEMENTS" => "N",
                        "TOP_DEPTH" => "2",
                        "SECTION_FIELDS" => array(
                            0 => "",
                            1 => "",
                        ),
                        "SECTION_USER_FIELDS" => array(
                            0 => "",
                            1 => "",
                        ),
                        "SECTION_URL" => "/gosserv/for/".$_REQUEST["FOR"]."/vedomstva/#SECTION_ID#/",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_GROUPS" => "Y",
                        "ADD_SECTIONS_CHAIN" => "Y",
                        "PROPERTY_FOR" => $_REQUEST["FOR"]
                    ),
                        false,
                        array("HIDE_ICONS" => "Y")
                    );
                } else {
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "services-service",
                        Array(
                            "IBLOCK_TYPE" => "gosserv",
                            "IBLOCK_ID" => "10",
                            "NEWS_COUNT" => "20",
                            "SORT_BY1" => "NAME",
                            "SORT_ORDER1" => "ASC",
                            "SORT_BY2" => "SORT",
                            "SORT_ORDER2" => "ASC",
                            "FILTER_NAME" => "CATEGORY_FILTER",
                            "FIELD_CODE" => array(0=>"",1=>"",),
                            "PROPERTY_CODE" => array(0=>"",1=>"",2=>"",),
                            "CHECK_DATES" => "Y",
                            "DETAIL_URL" => "/gosserv/for/".$_REQUEST["FOR"]."/".$_REQUEST["MODE"]."/#SECTION_ID#/#ELEMENT_ID#/",
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
                            "DISPLAY_BOTTOM_PAGER" => "Y",
                            "PAGER_TITLE" => "Услуги",
                            "PAGER_SHOW_ALWAYS" => "N",
                            "PAGER_TEMPLATE" => "",
                            "PAGER_DESC_NUMBERING" => "N",
                            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                            "PAGER_SHOW_ALL" => "Y",
                            "DISPLAY_DATE" => "N",
                            "DISPLAY_NAME" => "Y",
                            "DISPLAY_PICTURE" => "N",
                            "DISPLAY_PREVIEW_TEXT" => "N",
                            "AJAX_OPTION_ADDITIONAL" => "",
                        )
                    );
                }
                ?>
            </div>
        </div>
        <?
    }
    ?>
<? } else { ?>
    <p class="alert alert-error">Для работы раздела "Госуслуги" необходим установленный модуль "Информационные блоки".</p>
<? } ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>