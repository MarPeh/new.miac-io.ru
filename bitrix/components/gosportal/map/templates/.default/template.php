<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<section>
	<div class="map-wrapper map-objects">
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

		<?if (Bitrix\Main\Loader::includeModule("bitrix.map"))  {
			$arParams['ROUTETYPE_PROP_CODE'] = 'UF_ROUTE_TYPE_MAP';
			$APPLICATION->IncludeComponent("bitrix:map.map", "modern", $arParams, $component);
		} else
			$APPLICATION->IncludeComponent("bitrix:news.list", "gid_".$arParams["DATA_TYPE"], $arParams, $component);?>
	</div>
</section>


