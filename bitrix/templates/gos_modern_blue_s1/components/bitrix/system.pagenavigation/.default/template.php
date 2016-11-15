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
if(!$arResult["NavShowAlways"])
{
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>

<div class="page-navigation-wrapper col-margin-bottom">
    <div class="page-navigation">
        <? if ($arResult["NavPageNomer"] > 2) { ?>
            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>" class="left-arr">&lsaquo;</a>
        <? } else { ?>
            <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="left-arr">&lsaquo;</a>
        <? } ?>
        <span class="page-navigation-pages">
            <? while($arResult["nStartPage"] <= $arResult["nEndPage"]) { ?>
                <? if ($arResult["nStartPage"] == $arResult["NavPageNomer"]) { ?>
                    <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>" class="current"><?=$arResult["nStartPage"]?></a>
                <? } elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false) { ?>
                    <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a>
                <? } else { ?>
                    <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a>
                <? } ?>
                <?$arResult["nStartPage"]++?>
            <? } ?>
        </span>
        <? if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) { ?>
            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>" class="right-arr">&rsaquo;</a>
        <? } ?>
    </div>
</div>