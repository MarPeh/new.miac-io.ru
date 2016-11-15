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
<?if (!empty($arResult)) { ?>
    <div class="white-box col-margin<? if (!$GLOBALS["IS_HOME"]) { ?> primary-border-box<? } ?> clearfix">
        <div class="sidebar-nav">
            <ul>
                <? $previousLevel = 0; foreach($arResult as $arItem) { ?>
                    <? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) { ?>
                        </ul></li>
                    <? } ?>
                    <? if ($arItem["IS_PARENT"]) { ?>
                        <? if ($arItem["DEPTH_LEVEL"] == 1) { ?>
                            <li class="parent<? if ($arItem["SELECTED"]) { ?> current<? } ?>">
                                <a<? if ($arItem["PARAMS"]["HTML_ID"]) { ?> id="<?echo $arItem["PARAMS"]["HTML_ID"]?>"<? } ?> href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                                <ul>
                        <? } else { ?>
                            <li><a<? if ($arItem["PARAMS"]["HTML_ID"]) { ?> id="<?echo $arItem["PARAMS"]["HTML_ID"]?>"<? } ?> href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                        <? } ?>
                    <? } else { ?>
                        <li<? if ($arItem["SELECTED"]) { ?> class="current"<? } ?>><a<? if ($arItem["PARAMS"]["HTML_ID"]) { ?> id="<?echo $arItem["PARAMS"]["HTML_ID"]?>"<? } ?> href="<?=$arItem["LINK"]?>">
                                <? if ($arItem["PARAMS"]["HTML_ID"] == "munOrderSelectedMenu") { ?>
                                    <? $frame = $this->createFrame()->begin('Загрузка'); ?><?=$arItem["TEXT"]?><? $frame->end(); ?>
                <? } else { ?>
                                <?=$arItem["TEXT"]?>
                <? } ?>
                            </a></li>
                    <? } ?>
                    <?$previousLevel = $arItem["DEPTH_LEVEL"];?>
                <? } ?>
                <? if ($previousLevel > 1) { ?>
                    </ul></li>
                <? } ?>
            </ul>
        </div>
    </div>
<? } ?>