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
			<?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
				<div class="news-item-date fl-l mt10"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></div>
			<?endif;?>
			<div class="fl-r">
				<a href="<?=$arParams['BACK_TO_LIST_URL']?>" class="btn btn-link"><i class="icon icon-arrow-left"></i><?=GetMessage("T_NEWS_DETAIL_BACK")?></a>
			</div>
		</div>
		<div class="news-item-text clearfix">
			<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
				<div class="mb10">
					<img
						src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
						alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
						title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
						/>
					</div>
			<?endif?>
			
			<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
				<div class="mb20">
					<?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?>
				</div>
			<?endif;?>

			<?if($arResult["NAV_RESULT"]):?>
				<?if($arParams["DISPLAY_TOP_PAGER"]):?>
					<?=$arResult["NAV_STRING"]?>
				<?endif;?>
				
				<?=$arResult["NAV_TEXT"];?>
				
				<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
					<hr>
					<?=$arResult["NAV_STRING"]?>
				<?endif;?>
			<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
				<?=$arResult["DETAIL_TEXT"];?>
			<?else:?>
				<?=$arResult["PREVIEW_TEXT"];?>
			<?endif?>
			
			<?foreach($arResult["FIELDS"] as $code=>$value):?>
				<?if (strlen($value)): ?>
					<p class="fz14">
						<?if ('PREVIEW_PICTURE' == $code || 'DETAIL_PICTURE' == $code)
						{
							?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?
							if (!empty($value) && is_array($value))
							{
								?><img src="<?=$value["SRC"]?>"><?
							}
						}
						else
						{
							?><?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?><?
						}
						?>
					</p>
				<?endif?>
			<?endforeach;?>
			<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
				<?if ((is_array($arProperty["DISPLAY_VALUE"]) && count($arProperty["DISPLAY_VALUE"]) > 0) || strlen($arProperty["DISPLAY_VALUE"])): ?>
					<p>
						<b><?=$arProperty["NAME"]?>:</b>&nbsp;
						<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
							<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
						<?else:?>
							<?=$arProperty["DISPLAY_VALUE"];?>
						<?endif?>
					</p>
				<?endif?>
			<?endforeach;?>
		</div> <!-- .news-item-text clearfix -->
	</div> <!-- .news-item -->
</div> <!-- .news-detail -->