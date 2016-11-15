<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$can_view_counter = $APPLICATION->IncludeComponent("gosportal:show_counter", "", array(), $component);?>
<div class="news-detail">
    <div class="news-item">
        <div class="clearfix">
            <?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):
                $arr = ParseDateTime($arResult['ACTIVE_FROM'], FORMAT_DATETIME);
                $arResult["DISPLAY_ACTIVE_FROM"]=(int)$arr["DD"]." ".ToLower(GetMessage("MONTH_".intval($arr["MM"])."_S"))." ".$arr["YYYY"];?>
                <div class="news-item-date fl-l mt10"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>
            <?endif;?>
            <div class="fl-r">
                <a href="<?=$this->__component->__parent->arParams['SEF_FOLDER']?>" class="btn btn-link">
                    <i class="icon icon-arrow-left"></i>Все <?=ToLower($this->__component->__parent->arParams['PAGER_TITLE'])?>
                </a>
            </div>
        </div>
        <div class="news-item-text clearfix">
        <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["PREVIEW_TEXT"]):?>
            <p><?=$arResult["PREVIEW_TEXT"];?></p>
        <?endif;?>
        <?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
            <h2><?=$arResult["NAME"]?></h2>
        <?endif;?>
        <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
            <img align="left" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>" title="<?=$arResult["NAME"]?>" />
        <?endif?>
        <?if(strlen($arResult["DETAIL_TEXT"])>0):?>
            <?echo $arResult["DETAIL_TEXT"];?>
        <?endif?>
        <?if (!empty($arResult['MEDIA_VIDEO'])) {?>
            <div style="width:400px;margin:0 auto;"><?$APPLICATION->IncludeComponent(
                "bitrix:player",
                "",
                Array(
                    "PLAYER_TYPE" => "auto",
                    "USE_PLAYLIST" => "N",
                    "PATH" => $arResult['MEDIA_VIDEO'],
                    "WIDTH" => "400",
                    "HEIGHT" => "300",
                    "FULLSCREEN" => "Y",
                    "SKIN_PATH" => "/bitrix/components/bitrix/player/mediaplayer/skins",
                    "SKIN" => "bitrix.swf",
                    "CONTROLBAR" => "bottom",
                    "WMODE" => "transparent",
                    "HIDE_MENU" => "N",
                    "SHOW_CONTROLS" => "Y",
                    "SHOW_STOP" => "N",
                    "SHOW_DIGITS" => "Y",
                    "CONTROLS_BGCOLOR" => "FFFFFF",
                    "CONTROLS_COLOR" => "000000",
                    "CONTROLS_OVER_COLOR" => "000000",
                    "SCREEN_COLOR" => "000000",
                    "WMODE_WMV" => "window",
                    "AUTOSTART" => "N",
                    "REPEAT" => "N",
                    "VOLUME" => "90",
                    "DISPLAY_CLICK" => "play",
                    "MUTE" => "N",
                    "HIGH_QUALITY" => "Y",
                    "ADVANCED_MODE_SETTINGS" => "N",
                    "BUFFER_LENGTH" => "10",
                    "DOWNLOAD_LINK_TARGET" => "_self",
                    "ALLOW_SWF" => "N"
                )
            );?></div><br />
        <?}?>
        <?if (!empty($arResult['MEDIA_PHOTO'])) {?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:photogallery.detail.list",
                "",
                Array(
                    "THUMBS_SIZE" => "120",
                    "SHOW_PAGE_NAVIGATION" => "bottom",
                    "SHOW_CONTROLS" => "N",
                    "SHOW_RATING" => "N",
                    "SHOW_SHOWS" => "N",
                    "SHOW_COMMENTS" => "N",
                    "SHOW_TAGS" => "N",
                    "MAX_VOTE" => "5",
                    "VOTE_NAMES" => array("0","1","2","3","4"),
                    "DISPLAY_AS_RATING" => "rating",
                    "IBLOCK_TYPE" => "photogallery",
                    "IBLOCK_ID" => $arResult['MEDIA_PHOTO_IBLOCK'],
                    "BEHAVIOUR" => "SIMPLE",
                    "SET_TITLE" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "SECTION_ID" => $arResult['MEDIA_PHOTO'],
                    "ELEMENT_LAST_TYPE" => "none",
                    "ELEMENT_SORT_FIELD" => "SORT",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_FIELD1" => "",
                    "ELEMENT_SORT_ORDER1" => "asc",
                    "PROPERTY_CODE" => array(),
                    "DETAIL_URL" => $arResult['MEDIA_PHOTO_URL'] . "#SECTION_ID#/#ELEMENT_ID#/",
                    "DETAIL_SLIDE_SHOW_URL" => $arResult['MEDIA_PHOTO_URL'] . "#SECTION_ID#/#ELEMENT_ID#/",
                    "SEARCH_URL" => "",
                    "USE_PERMISSIONS" => "N",
                    "GROUP_PERMISSIONS" => array("1"),
                    "USE_DESC_PAGE" => "Y",
                    "PAGE_ELEMENTS" => "50",
                    "PAGE_NAVIGATION_TEMPLATE" => "",
                    "DATE_TIME_FORMAT" => "d.m.Y",
                    "ADDITIONAL_SIGHTS" => array(),
                    "PICTURES_SIGHT" => array()
                ),
            false
            );?>
        <?}?>
        </div>
    </div>
</div> 