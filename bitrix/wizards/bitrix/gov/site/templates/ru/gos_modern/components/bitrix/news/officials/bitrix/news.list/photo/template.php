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
$this->setFrameMode(true);?>
<?if(count($arResult["ITEMS"])>0):?>
	<div class="news-list">
		<b><?=$arResult["NAME"]?></b>
		<table cellpadding="5" cellspacing="0" border="0">
		<tr valign="center">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<td align="center">
			<?if(is_array($arItem["PREVIEW_PICTURE"])):?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["NAME"]?>" /></a>
			<?else:?>
				&nbsp;
			<?endif?>
			</td>
		<?endforeach;?>
		</tr>
		<tr valign="top">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<td align="center">
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
			</td>
		<?endforeach;?>
		</tr>
		</table>
	</div>
<?endif?>
