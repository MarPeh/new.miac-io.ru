<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	<?
	if (Bitrix\Main\Loader::includeModule("bitrix.map"))  {
	?>
		<div class="tts-tabs col-margin-bottom">
			<?$APPLICATION->IncludeComponent("bitrix:menu", "map", array(
				"ROOT_MENU_TYPE" => $arParams["MENU_TYPE"],
				"MENU_CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"MENU_CACHE_TIME" => $arParams["CACHE_TIME"],
				"MENU_CACHE_USE_GROUPS" => "Y",
				"MENU_CACHE_GET_VARS" => array(
				),
				"MAX_LEVEL" => "1",
				"CHILD_MENU_TYPE" => $arParams["MENU_TYPE"],
				"USE_EXT" => "N",
				"DELAY" => "N",
				"ALLOW_MULTI_SELECT" => "N"
			),
				false
			);?>

			<?
			Bitrix\Main\Loader::includeModule("bitrix.gossite");
			$detector = new Mobile_Detect();

			$arParams['ROUTETYPE_PROP_CODE'] = 'UF_ROUTE_TYPE_MAP';
			$arParams['BAR_HEIGHT'] = '44';
			$arParams['DIRECTION_LINK'] = "#SITE_DIR#city/turizm/mobile_direction.php?ibtype=" . $arParams['IBLOCK_TYPE'] . "&ibid=" . $arParams['IBLOCK_ID'];

			if ($detector->isMobile() && !$detector->isTablet()) {
				echo "<div class=\"white-box col-margin-bottom padding-box\">";
				$APPLICATION->IncludeComponent("bitrix:map.objects.mobile", "", $arParams, $component);
				echo "</div>";
			}
			else {
				$APPLICATION->IncludeComponent("bitrix:map.map", "modern", $arParams, $component);
			}
			?>
		</div>
			<?
        } else {
            ?>
            <div class="white-box padding-box">
            <?if ($USER->IsAdmin()) { ?>
                <div class="alert mb20">Для функционирования данного раздела необходимо установить модуль <a href="http://marketplace.1c-bitrix.ru/solutions/bitrix.map/">"1С-Битрикс: Интерактивная карта объектов"</a></div>
            <? } ?>
			<p><b>Раздел на реконструкции.</b></p>
			<p>В ближайшее время мы обновим информацию об объектах  и  событиях города.</p>
			<p>Приносим извинения за неудобства.</p>
			</div>
			<?
        }
        ?>
    
