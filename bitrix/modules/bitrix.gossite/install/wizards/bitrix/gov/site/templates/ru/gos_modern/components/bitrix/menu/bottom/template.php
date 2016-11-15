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
    <div class="content footer-menu-content">
        <?
        $previousLevel = 0;
        foreach($arResult as $arItem) { ?>
            <? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel) { ?>
                </ul></li></ul></div>
            <? } ?>
            <? if ($arItem["IS_PARENT"]) { ?>
                <? if ($arItem["DEPTH_LEVEL"] == 1) { ?>
                    <div class="col col-mb-12 col-4">
                        <ul>
                            <li class="col-margin-bottom">
                                <div class="h4"><?=$arItem["TEXT"]?></div>
                                    <ul>
                <? } else { ?>
                    <li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                <? } ?>
            <? } else { ?>
                <? if ($arItem["DEPTH_LEVEL"] > 1) { ?>
                    <li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                <? } ?>
            <? } ?>
            <?$previousLevel = $arItem["DEPTH_LEVEL"];?>
        <? } ?>
        <? if ($previousLevel > 1) { ?>
            </ul></li></ul></div>
        <? } ?>
    </div>
<? } ?>