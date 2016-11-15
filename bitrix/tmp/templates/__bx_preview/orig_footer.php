<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
                <? $GLOBALS["APPLICATION"]->AddBufferContent("\\Bitrix\\GosSite\\Layout::printWrapper", "footer"); ?>
            </div> <!-- .col col-mb-12 col-9 col-margin-bottom -->
				<div class="col col-mb-12 col-3 col-margin-bottom">
					<? if ($GLOBALS["IS_HOME"]) { ?>
                    <div class="white-box padding-box primary-border-box pt0">
                       <div class="sidebar-header h3">Общие сведения</div>
                        <div class="sidebar-content fz14">
                            <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                ".default",
                                array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => "/includes/about.php"
                                ),
                                false
                            );?>
                        </div>
                    </div>
					<? } ?>

					<?$APPLICATION->IncludeComponent(
						"bitrix:menu",
						"sidebar",
						array(
							"ROOT_MENU_TYPE" => "left",
							"MENU_CACHE_TYPE" => "N",
							"MENU_CACHE_TIME" => "3600",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"MENU_CACHE_GET_VARS" => array(
							),
							"MAX_LEVEL" => "2",
							"CHILD_MENU_TYPE" => "left",
							"USE_EXT" => "Y",
							"DELAY" => "N",
							"ALLOW_MULTI_SELECT" => "N"
						),
						false
					);?>

					<div class="col-margin left-image-b-block">
					<?$APPLICATION->IncludeComponent(
						"bitrix:advertising.banner",
						"",
						array(
							"TYPE" => "SIDEBAR_240_400",
							"NOINDEX" => "N",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "0"
						),
						false
					);
                    ?>
                    </div>
					<?$APPLICATION->IncludeComponent("bitrix:advertising.banner", "text", array(
	"TYPE" => "SIDEBAR_TEXT",
		"QUANTITY" => "2",
		"NOINDEX" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "0"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);
					?>
                    <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"important-links", 
	array(
		"COMPONENT_TEMPLATE" => "important-links",
		"ROOT_MENU_TYPE" => "important",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
                </div> <!-- .col col-mb-12 col-3 col-margin-bottom -->
        </div> <!-- .content -->
    </div> <!-- .container container-main col-margin-top -->

</div> <!-- .body-wrapper clearfix -->

<div class="footer-wrapper">
	<footer class="container container-footer">

		<?$APPLICATION->IncludeComponent("bitrix:menu", "bottom", array(
	"COMPONENT_TEMPLATE" => "main",
		"ROOT_MENU_TYPE" => "top",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => "",
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>

		<div class="content">
			<div class="col col-mb-12 col-4">
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					".default",
					array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "inc",
						"EDIT_TEMPLATE" => "",
						"PATH" => "/includes/copyright.php"
					),
					false
				);?><br>
				<a href="/contacts/">Контакты</a>
			</div> <!-- .col col-mb-12 col-4 -->

			<div class="col col-mb-12 col-4">
				<?$APPLICATION->IncludeComponent("bitrix:main.include", "template1", Array(
	"AREA_FILE_SHOW" => "file",	// Показывать включаемую область
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",	// Шаблон области по умолчанию
		"PATH" => "/includes/bottom-address.php",	// Путь к файлу области
	),
	false
);?>
			</div> <!-- .col col-mb-12 col-4 -->

			<div class="col col-mb-12 col-4">
				<?$APPLICATION->IncludeComponent(
					"bitrix:menu",
					"social",
					array(
						"COMPONENT_TEMPLATE" => "social",
						"ROOT_MENU_TYPE" => "social",
						"MENU_CACHE_TYPE" => "N",
						"MENU_CACHE_TIME" => "3600",
						"MENU_CACHE_USE_GROUPS" => "Y",
						"MENU_CACHE_GET_VARS" => array(
						),
						"MAX_LEVEL" => "1",
						"CHILD_MENU_TYPE" => "left",
						"USE_EXT" => "N",
						"DELAY" => "N",
						"ALLOW_MULTI_SELECT" => "N"
					),
					false
				);?>
				<div id="bx-composite-banner"><?/*Это место для композитного баннера*/?></div>
			</div> <!-- .col col-mb-12 col-4 -->
                        <div class="col col-mb-12 col-4">
                        <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                  "AREA_FILE_SHOW" => "sect",
                  "AREA_FILE_SUFFIX" => "counter",
                  "AREA_FILE_RECURSIVE" => "Y",
                  "EDIT_TEMPLATE" => ""
               ),
               false
            );?> 
                        </div>

		</div>
	</footer>
</div> <!-- .footer-wrapper -->

<?
$frame = new \Bitrix\Main\Page\FrameHelper("auth-area-bottom");
$frame->begin();
?>
<div class="mobile-nav-wrapper">
    <div class="mobile-nav">
        <div class="content p20 pb0">
	        <? if ($GLOBALS["USER"]->IsAuthorized()) { ?>
            <div class="col col-mb-8 pl0">
                <a class="btn btn-square btn-dark btn-block" href="/personal/"><i class="icon icon-lk"></i> Личный кабинет</a>
            </div>
            <div class="col col-mb-4 pr0">
                <a class="btn btn-square btn-dark btn-block" href="/?logout=yes">Выйти</a>
            </div>
	        <? } else { ?>
		        <div class="col col-mb-8 pl0">
			        <a class="btn btn-square btn-dark btn-block" href="/auth/"><i class="icon icon-lk"></i> Авторизация</a>
		        </div>
	        <? } ?>
        </div>
    </div>
</div>
<?
$frame->end();
?>

</body>
</html>