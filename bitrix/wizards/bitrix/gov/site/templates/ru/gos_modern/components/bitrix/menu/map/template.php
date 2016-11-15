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
<?
if (!empty($arResult)) {
    ?>
    <div class="tts-tabs-switchers-wrapper">
    <ul class="tts-tabs-switchers">
    <?
    foreach ($arResult as $arItem) {
        ?>
        <li class="tts-tabs-switcher<? if ($arItem["SELECTED"]) { ?> active<? } ?>" data-target-self="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></li>
        <?
    }
    ?>
    </ul>
    </div>
    <?
}