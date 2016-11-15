<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);?>

<?if (!empty($arResult)) { ?>
    <div class="social-networks">
        <? foreach($arResult as $arItem) { ?>
            <a href="<?=$arItem["LINK"]?>" title="<?=$arItem["TEXT"]?>" class="social-network"><i class="icon icon-social-<?=$arItem["PARAMS"]["CLASS"]?>"<? if ($arItem["PARAMS"]["CLASS"] == "" && $arItem["PARAMS"]["img"] != "") { ?> style="background-image:url(<?echo $arItem["PARAMS"]["img"]?>);"<? } ?>></i></a>
        <? } ?>
    </div>
<? } ?>
