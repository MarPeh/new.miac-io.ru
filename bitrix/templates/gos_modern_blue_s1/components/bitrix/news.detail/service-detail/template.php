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
<? if (!empty($arResult["PREVIEW_TEXT"])) { ?><div class="col-margin-bottom"><?echo $arResult["PREVIEW_TEXT"]?></div><? } ?>

<div class="white-box padding-box col-margin-bottom">
<? if ($arResult['CURRENT_PROPERTY'] == "MAIN_INFO") { ?>
        <table class="table table-bordered table-responsive mb0">
            <tbody>
            <tr>
                <td  class="td-gray"><?=GetMessage("VEDOMSTVO")?></td>
                <td>
                    <a href="<?=$arResult['LIST_PAGE_URL']?>"><?=$arResult['SECTION_NAME']?></a>
                </td>
            </tr>
            <tr>
                <td  class="td-gray"><?=GetMessage("FOR")?></td>
                <td><?echo $arResult["DISPLAY_PROPERTIES"]["FOR"]["DISPLAY_VALUE"]?></td>
            </tr>
            <tr>
                <td  class="td-gray"><?=GetMessage("DOCUMENTS_TEXT")?></td>
                <td>
                    <? if(!$arResult["DISPLAY_PROPERTIES"]['DOCUMENTS_TEXT']['~VALUE'][0]) { ?>
                        <?=$arResult["DISPLAY_PROPERTIES"]['DOCUMENTS_TEXT']['~VALUE']['TEXT']?>
                    <? } ?>
                    <ol>
                        <? foreach ($arResult["DISPLAY_PROPERTIES"]['DOCUMENTS_FILES']["DISPLAY_VALUE"] as $fileHref) { ?>
                            <li><?echo $fileHref?></li>
                        <? } ?>
                    </ol>
                </td>
            </tr>
            <tr>
                <td  class="td-gray"><?=GetMessage("PAYMENT")?></td>
                <td>
                    <?=$arResult["DISPLAY_PROPERTIES"]['PAYMENT']['VALUE']?>
                </td>
            </tr>
            <tr>
                <td  class="td-gray"><?=GetMessage("SROK")?></td>
                <td>
                    <?=$arResult["DISPLAY_PROPERTIES"]['SROK']['~VALUE']['TEXT']?>
                </td>
            </tr>
            <tr>
                <td  class="td-gray"><?=GetMessage("RESULT")?></td>
                <td>
                    <?=$arResult["DISPLAY_PROPERTIES"]['RESULT']['~VALUE']['TEXT']?>
                </td>
            </tr>
            </tbody>
        </table>
<? } else { ?>
            <?=$arResult["DISPLAY_PROPERTIES"][$arResult['CURRENT_PROPERTY']]["DISPLAY_VALUE"]?>
<? } ?>
</div>

<?$page=$APPLICATION->GetCurPage();?>
<ul class="unstyled content clearfix">
    <li class="col col-mb-12 col-6">
        <?$url=str_replace("#ELEMENT_ID#", $arResult["ID"], $arParams["~MAIN_INFO_URL"])
        ?>
        <?if ($page!=$url):?>
            <a href="<?=$url?>" title="<?=GetMessage("SERVICE_INFO")?>" <?if($arResult['CURRENT_PROPERTY']=="MAIN_INFO"):?>class="selected"<?endif?>>
                <?=GetMessage("SERVICE_INFO")?>
            </a>
        <?else:?>
            <span>
                    <?=GetMessage("SERVICE_INFO")?>
                </span>
        <?endif?>
    </li>
    <?
    $mainProperties=array("FOR","DOCUMENTS_TEXT","DOCUMENTS_FILES","NAME","PAYMENT","SROK","RESULT");
    foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):
        if(!in_array($pid, $mainProperties)):?>
            <li class="col col-mb-12 col-6">
                <?if ($page!=$url.$pid.'/'):?>
                    <a href="<?=$url?><?=$pid?>/" title="<?=$arProperty['NAME']?>" <?if($arResult['CURRENT_PROPERTY']==$pid):?>class="selected"<?endif?>>
                        <?=$arProperty['NAME']?>
                    </a>
                <?else:?>
                    <span>
                            <?=$arProperty['NAME']?>
                        </span>
                <?endif?>
            </li>
        <?endif;
    endforeach;
    ?>
</ul>