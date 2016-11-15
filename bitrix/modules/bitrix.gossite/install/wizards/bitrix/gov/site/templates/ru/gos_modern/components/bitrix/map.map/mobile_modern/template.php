<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<? if (strlen($arResult["ERROR"]) > 0) { ?>
    <? ShowError($arResult["ERROR"]); ?>
<? } else { ?>
    <script>
    $GeoMapp.init({
        siteMode: true,
        device: {mobile: 'mobile_map_v3.js'},
        mapBounds: <?=$arResult["PARAMS"]["BOUNDS"]?>,
        defaultPath: <?=$arResult["PARAMS"]["DEFAULT_PATHS"]?>,
        mapType: '<?=$arParams["MAP_TYPE"]?>',
        pageType: '<?=$arParams["DATA_TYPE"]?>',
        loadTime: <?=$arResult["PARAMS"]["LOAD_TIME"]?>,
        responseTime: <?=$arResult["PARAMS"]["RESPONSE_TIME"]?>,
        universalMarker: <?=$arParams["UNIVERSAL_MARKER"] == "Y" ? "true" : "false"?>,
        noCatIcons: <?=$arParams["NO_CAT_ICONS"] == "Y" ? "true" : "false"?>,
        barHeight: <?=intval($arParams["BAR_HEIGHT"])?>,
        plateHeight: <?=intval($arParams["PLATE_HEIGHT"])?>,
        fewObjectsHeight: <?=intval($arParams["FEW_OBJECTS_HEIGHT"])?>,
        verticalTime: <?=$arResult["PARAMS"]["VERTICAL_TIME"]?>,
        horizontalTime: <?=$arResult["PARAMS"]["HORIZONTAL_TIME"]?>,
        ajax: '<?=$arParams["AJAX_PATH"]?>',
        <? if (!empty($arParams["DIRECTION_LINK"])) { ?>directionLink: '<?=$arParams["DIRECTION_LINK"]?>',<? } ?>
        <? foreach ($arResult["PARAMS"]["ICONS"] as $strVarName => $strData) { ?>
            <?=$strVarName?>: <?=$strData?>,
        <? } ?>
        interfaceText: <?=$arResult["INTERFACE"]["main"]?>,
        routeMessages: <?=$arResult["INTERFACE"]["routes"]?>,
        parseMessages: <?=$arResult["INTERFACE"]["errors"]?>,
        <? if(!empty($arResult["JSON_FIELDS"])): ?>
        fields: <?=$arResult["JSON_FIELDS"]?>,
        <? endif; ?>
        cats: <?=$arResult["JSON_SECTIONS"]?>,
        <? if ($arParams["LOAD_ITEMS"]) { ?>
        items: <?=$arResult["JSON_ELEMENTS"]?>,
        <? } ?>
        <? if (!empty($arParams["QUERY"])) { ?>
        query: '<?= $arParams["QUERY"] ?>'
        <? } ?>
        routeType: <?=$arResult["PARAMS"]["ROUTE_TYPES"]?>
    });
    </script>

    <div id="bxMapContainer" class="bxmap-wrapper"></div>
<? } ?>