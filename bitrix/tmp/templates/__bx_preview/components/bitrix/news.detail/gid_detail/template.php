<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="news-detail">
	<div class="news-item">
		<div class="clearfix">
			<div class="news-item-date fl-l mt10"><?echo $arResult["DISPLAY_ACTIVE_FROM"]?></div>
			<div class="fl-r"><a href="<?echo $arResult["SECTION_URL"]?>" class="btn btn-link"><i class="icon icon-arrow-left"></i><?=GetMessage("NEWS_LIST") ?> <?= ToLower($arResult["IBLOCK"]["ELEMENTS_NAME"]) ?></a></div>
		</div>
		<div class="news-item-text clearfix">

            <? if(is_array($arResult["DETAIL_PICTURE"])) { ?>
                <div class="news-item-image">
                    <img src="<?echo $arResult["DETAIL_PICTURE"]["SRC"]?>"
                         width="<?echo $arResult["DETAIL_PICTURE"]["WIDTH"]?>"
                         height="<?echo $arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
                         alt="<?echo $arResult["DETAIL_PICTURE"]["ALT"]?>"
                         title="<?echo $arResult["DETAIL_PICTURE"]["TITLE"]?>"
                         align="left">
                </div>
            <? } ?>

            <?echo $arResult["PREVIEW_TEXT"];?>
            <?echo $arResult["DETAIL_TEXT"];?>

            <hr>
            <? foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty) { ?>
                <b><?echo $arProperty["NAME"]?>:</b>&nbsp;
                <? if (is_array($arProperty["DISPLAY_VALUE"])) { ?>
                    <?echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
                <? } else { ?>
                    <?echo $arProperty["DISPLAY_VALUE"];?>
                <? } ?>
                <br />
            <? } ?>
		</div>
	</div>
</div>