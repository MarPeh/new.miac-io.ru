<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?$APPLICATION->ShowTitle()?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="<?=SITE_TEMPLATE_PATH?>/favicon.png">
	<script data-skip-moving="true">
		function loadFont(t,e,n,o){function a(){if(!window.FontFace)return!1;var t=new FontFace("t",'url("data:application/font-woff2,") format("woff2")',{}),e=t.load();try{e.then(null,function(){})}catch(n){}return"loading"===t.status}var r=navigator.userAgent,s=!window.addEventListener||r.match(/(Android (2|3|4.0|4.1|4.2|4.3))|(Opera (Mini|Mobi))/)&&!r.match(/Chrome/);if(!s){var i={};try{i=localStorage||{}}catch(c){}var d="x-font-"+t,l=d+"url",u=d+"css",f=i[l],h=i[u],p=document.createElement("style");if(p.rel="stylesheet",document.head.appendChild(p),!h||f!==e&&f!==n){var w=n&&a()?n:e,m=new XMLHttpRequest;m.open("GET",w),m.onload=function(){m.status>=200&&m.status<400&&(i[l]=w,i[u]=m.responseText,o||(p.textContent=m.responseText))},m.send()}else p.textContent=h}}

		loadFont('OpenSans', '<?=SITE_TEMPLATE_PATH?>/opensans.css', '<?=SITE_TEMPLATE_PATH?>/opensans-woff2.css');
	</script>
	<?
    $APPLICATION->ShowHead();

	Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/special_version.css");

    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH .  "/js/-jquery.min.js");
    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH .  "/js/js.cookie.min.js");
    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH .  "/js/jquery.formstyler.min.js");
    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH .  "/js/jquery.matchHeight-min.js");
    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH .  "/js/jquery.mobileNav.min.js");
    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH .  "/js/jquery.tabsToSelect.min.js");
    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH .  "/js/owl.carousel.min.js");
    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH .  "/js/perfect-scrollbar.jquery.min.js");
    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH .  "/js/responsive-tables.js");
    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH .  "/js/special_version.js");
    Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH .  "/js/main.js");
	?>
</head>

<body>
<div class="mb-hide"><?$APPLICATION->ShowPanel();?></div>
<?
$GLOBALS["IS_HOME"] = $APPLICATION->GetCurPage(true) === SITE_DIR . "index.php";

if (!IsModuleInstalled("bitrix.gossite")) {
	echo "<div class=\"alert alert-error m50\">Для корректной работы сайта необходим модуль \"1С-Битрикс: Официальный сайт государственной организации\"</div>";
}
?>
<div class="body-wrapper clearfix">
    <div class="special-settings">
        <div class="container special-panel-container">
            <div class="content">
                <div class="aa-block aaFontsize">
                    <div class="fl-l">Размер:</div>
                    <a class="aaFontsize-small" data-aa-fontsize="small" href="#" title="Уменьшенный размер шрифта">A</a><!--
				 --><a class="aaFontsize-normal a-current" href="#" data-aa-fontsize="normal" title="Нормальный размер шрифта">A</a><!--
				 --><a class="aaFontsize-big" data-aa-fontsize="big" href="#" title="Увеличенный размер шрифта">A</a>
                </div>
                <div class="aa-block aaColor">
                    Цвет:
                    <a class="aaColor-black a-current" data-aa-color="black" href="#" title="Черным по белому"><span>C</span></a><!--
				 --><a class="aaColor-yellow" data-aa-color="yellow" href="#" title="Желтым по черному"><span>C</span></a><!--
				 --><a class="aaColor-blue" data-aa-color="blue" href="#" title="Синим по голубому"><span>C</span></a>
                </div>

                <div class="aa-block aaImage">
                    Изображения
				<span class="aaImage-wrapper">
					<a class="aaImage-on a-current" data-aa-image="on" href="#">Вкл.</a><!--
					 --><a class="aaImage-off" data-aa-image="off" href="#">Выкл.</a>
				</span>
                </div>
                <span class="aa-block"><a href="/?set-aa=normal" data-aa-off><i class="icon icon-special-version"></i> Обычная версия сайта</a></span>
            </div>
        </div> <!-- .container special-panel-container -->
    </div> <!-- .special-settings -->

	<header>

		<div class="container container-top-header">
			<div class="content">
				<div class="col col-mb-5 col-3 col-dt-2 col-ld-3">
                    <?
                    $frame = new \Bitrix\Main\Page\FrameHelper("auth-area");
                    $frame->begin();

                    if ($GLOBALS["USER"]->IsAuthorized()) {
                        ?>
                        <div class="top-header-nav">
                            <ul class="top-header-nav-ul">
                                <li class="parent">
                                    <a class="top-header-link" href="/personal/profile/"><i class="icon icon-lk"></i><span class="col-mb-hide col-hide col-dt-hide"> Мой профиль</span></a>
                                    <ul class="second-level">
                                        <li>
                                            <a href="/personal/profile/"> Изменить</a>
                                        </li>
                                        <li>
                                            <a href="/?logout=yes">Выйти</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
					    <?
                    } else {
                        ?>
                        <a class="top-header-link" href="/auth/"><i class="icon icon-lk"></i><span class="col-mb-hide col-hide col-dt-hide"> Войти</span></a>
					    <?
                    }
                    $frame->end();
                    ?>
				</div>
				<div class="col col-mb-hide col-7 col-dt-8 col-ld-7">
					<?$APPLICATION->IncludeComponent(
						"bitrix:menu",
						"top",
						array(
							"COMPONENT_TEMPLATE" => "top",
							"ROOT_MENU_TYPE" => "info",
							"MENU_CACHE_TYPE" => "N",
							"MENU_CACHE_TIME" => "3600",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"MENU_CACHE_GET_VARS" => array(
							),
							"MAX_LEVEL" => "2",
							"CHILD_MENU_TYPE" => "left",
							"USE_EXT" => "N",
							"DELAY" => "N",
							"ALLOW_MULTI_SELECT" => "N"
						),
						false
					);?>
				</div>

				<div class="col col-mb-7 col-2 col-dt-2">
					<div class="top-header-right-side">
						<span class="aa-hide" itemprop="Copy"><a class="fl-r top-header-link ta-center" href="/?set-aa=special" data-aa-on><i class="icon icon-special-version"></i></a></span>

						<div class="search-block fl-r">
							<div class="search-button"><i class="icon icon-search"></i> <span class="col-mb-hide col-hide col-dt-hide">Поиск</span></div>
                            <?$APPLICATION->IncludeComponent("bitrix:search.title", "modern_search", Array(
                                "SHOW_INPUT" => "Y",
                                "INPUT_ID" => "title-search-input",
                                "CONTAINER_ID" => "searchTitle",
                                "PAGE" => "/search/index.php",
                                "NUM_CATEGORIES" => "1",
                                "TOP_COUNT" => "5",
                                "ORDER" => "date",
                                "USE_LANGUAGE_GUESS" => "Y",
                                "CHECK_DATES" => "N",
                                "SHOW_OTHERS" => "N",
                                "CATEGORY_0_TITLE" => "Результаты:",
                                "CATEGORY_0" => array(
                                    0 => "no",
                                )
                            ),
                                false
                            );?>
						</div>
					</div>
				</div> <!-- .col col-mb-7 col-2 col-dt-2 -->
			<!-- </div> <!-- .content -->
		<!-- </div> <!-- .container container-top-header -->

		<div class="container container-white pt30">
			<div class="content">
				<div class="col col-mb-12 col-dt-6 col-margin-bottom">
                    <a href="/" class="logo">
                        <img src="<?=COption::GetOptionString('bitrix.gossite', 'coat', '/upload/coats/unknown.png', SITE_ID)?>" />
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/includes/title.php"
                            ),
                            false
                        );?>
                    </a>
				</div> <!-- .col col-mb-12 col-dt-6 col-margin-bottom -->
				<div class="col col-mb-12 col-6 col-dt-3 mt10 col-margin-bottom">
                    <b><?$APPLICATION->IncludeComponent("bitrix:main.include", "template2", array(
	"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/includes/top-address.php"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?></b><br><small class="text-light"><?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
	"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/includes/top-address-desc.php"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?></small>
				</div> <!-- .col col-mb-12 col-6 col-dt-3 mt10 col-margin-bottom -->
				<div class="col col-mb-12 col-6 col-dt-3 mt10 col-margin-bottom">
                    <b><?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	"template2", 
	array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/includes/top-address.php",
		"COMPONENT_TEMPLATE" => "template2"
	),
	false
);?></b><br><small class="text-light"><?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	".default", 
	array(
		"AREA_FILE_SHOW" => "file",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"PATH" => "/includes/top-phone.php",
		"COMPONENT_TEMPLATE" => ".default"
	),
	false,
	array(
		"ACTIVE_COMPONENT" => "Y"
	)
);?></small>
				</div> <!-- .col col-mb-12 col-6 col-dt-3 mt10 col-margin-bottom -->
			</div> <!-- .content -->
		</div> <!-- .container container-white pt10 -->

		<div class="container container-top-navigation">
			<div class="content">
				<div class="col col-mb-hide col-12">
					<div class="top-nav-block">
                        <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"main", 
	array(
		"COMPONENT_TEMPLATE" => "main",
		"ROOT_MENU_TYPE" => "top",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
					</div> <!-- .top-nav-block -->
				</div> <!-- .col col-mb-hide col-12 -->
			</div>
		</div> <!-- .container container-top-navigation -->
	</header>

	<? if ($GLOBALS["IS_HOME"]) { ?>
		<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"slider", 
	array(
		"COMPONENT_TEMPLATE" => "slider",
		"IBLOCK_TYPE" => "information",
		"IBLOCK_ID" => "23",
		"NEWS_COUNT" => "5",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "NAME",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
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
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
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
	<? } ?>

	<div class="container container-main col-margin-top">
		<div class="content">
			<div class="col col-mb-12 col-9 col-margin-bottom">
				<div class="content">

					<?$APPLICATION->IncludeComponent(
						"bitrix:breadcrumb",
						"breadcrumb",
						array(),
						false
					);?>

					<?// На главной не должно быть заголовка?>
					<?if (!$GLOBALS["IS_HOME"]) { ?>
						<div class="col col-mb-12 col-margin-bottom">
							<h1><?$APPLICATION->ShowTitle(false);?></h1>
						</div> <!-- .col col-mb-12 col-margin-bottom -->
					<? } ?>
				</div> <!-- .content -->
                <? $APPLICATION->AddBufferContent("\\Bitrix\\GosSite\\Layout::printWrapper", "header"); ?>