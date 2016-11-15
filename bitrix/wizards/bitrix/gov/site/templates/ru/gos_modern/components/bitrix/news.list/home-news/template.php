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
<? if (($itemsCount = count($arResult["ITEMS"])) > 0) { ?>
    <div class="double-header-block clearfix col-margin-bottom">
        <h2 class="double-header"><?=GetMessage("NEW_TITLE");?></h2>
        <div class="double-header-link"><a href="<?echo $arResult["ITEMS"][0]["LIST_PAGE_URL"]?>"><?=GetMessage("NEW_LIST");?><i class="icon icon-arrow-right"></i></a></div>
    </div>
    <div class="content">
        <div class="col col-mb-12 col-12 col-dt-<?echo $itemsCount == 1 ? "12" : "6"?>">
            <div class="white-box primary-border-box padding-box col-margin-bottom equal">
                <?
                $this->AddEditAction($arResult["ITEMS"][0]['ID'], $arResult["ITEMS"][0]['EDIT_LINK'], CIBlock::GetArrayByID($arResult["ITEMS"][0]["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arResult["ITEMS"][0]['ID'], $arResult["ITEMS"][0]['DELETE_LINK'], CIBlock::GetArrayByID($arResult["ITEMS"][0]["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="news-item news-item-main" id="<?=$this->GetEditAreaId($arResult["ITEMS"][0]['ID']);?>">
                    <div class="news-item-date"><?echo $arResult["ITEMS"][0]["DISPLAY_ACTIVE_FROM"]?></div>
                    <div class="news-item-image">
                        <h3 class="h2 mb-block"><a href="<?echo $arResult["ITEMS"][0]["DETAIL_PAGE_URL"]?>"><?echo $arResult["ITEMS"][0]["NAME"]?></a></h3>
                        <? if (is_array($arResult["ITEMS"][0]["DETAIL_PICTURE"])) { ?>
                            <div class="big-image-col">
                                <a href="<?echo $arResult["ITEMS"][0]["DETAIL_PAGE_URL"]?>">
                                    <img
                                        src="<?=$arResult["ITEMS"][0]["DETAIL_PICTURE"]["SRC"]?>"
                                        alt="<?=$arResult["ITEMS"][0]["DETAIL_PICTURE"]["ALT"]?>"
                                        title="<?=$arResult["ITEMS"][0]["DETAIL_PICTURE"]["TITLE"]?>"
                                    />
                                </a>
                            </div>
                        <? } ?>
                    </div> <!-- .news-item-image -->
                    <div class="news-item-text">
                        <h3 class="news-item-header mb-hide"><a href="<?echo $arResult["ITEMS"][0]["DETAIL_PAGE_URL"]?>"><?echo $arResult["ITEMS"][0]["NAME"]?></a></h3>
                        <?echo $arResult["ITEMS"][0]["PREVIEW_TEXT"]?>
                    </div> <!-- .news-item-text -->
                </div> <!-- .news-item news-item-main -->
            </div> <!-- .white-box primary-border-box padding-box col-margin-bottom equal -->
        </div> <!-- .col col-mb-12 col-12 col-dt-6 -->
        <? if ($itemsCount > 1) { ?>
            <div class="col col-mb-12 col-12 col-dt-6">
                <div class="white-box padding-box col-margin-bottom equal">
                    <? for($i = 1; $i < $itemsCount; $i++) { ?>
                        <?
                        $this->AddEditAction($arResult["ITEMS"][$i]['ID'], $arResult["ITEMS"][$i]['EDIT_LINK'], CIBlock::GetArrayByID($arResult["ITEMS"][$i]["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arResult["ITEMS"][$i]['ID'], $arResult["ITEMS"][$i]['DELETE_LINK'], CIBlock::GetArrayByID($arResult["ITEMS"][$i]["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>
                        <div class="news-item" id="<?=$this->GetEditAreaId($arResult["ITEMS"][$i]['ID']);?>">
                            <div class="news-item-date"><?echo $arResult["ITEMS"][$i]["DISPLAY_ACTIVE_FROM"]?></div>
                            <div class="news-item-text">
                                <h3 class="news-item-header"><a href="<?echo $arResult["ITEMS"][$i]["DETAIL_PAGE_URL"]?>"><?echo $arResult["ITEMS"][$i]["NAME"]?></a></h3>
                            </div> <!-- .news-item-text -->
                        </div> <!-- .news-item -->
                    <? } ?>
                </div> <!-- .white-box padding-box col-margin-bottom equal -->
            </div> <!-- .col col-mb-12 col-12 col-dt-6 -->
        <? } ?>
    </div> <!-- .content -->
<? } ?>