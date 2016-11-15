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
<? if (count($arResult) > 0) { ?>
    <div class="white-box padding-box">
        <ul class="external-links-list">
            <? foreach($arResult as $arItem) { ?>
                <li><a href="<?echo $arItem["LINK"]?>"><?echo $arItem["TEXT"]?></a></li>
            <? } ?>
        </ul>
    </div>
<? } ?>