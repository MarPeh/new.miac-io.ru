<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!empty($arResult["CATEGORIES"])):?>
	<div class="search-result col-margin">
		<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
			<b>&nbsp;<?echo $arCategory["TITLE"]?></b>
			<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
					<?if($category_id === "all"):?>
					<?elseif(isset($arItem["ICON"])):?>
						<a class="search-result-item" href="<?echo $arItem["URL"]?>"><img src="<?echo $arItem["ICON"]?>"><?echo $arItem["NAME"]?></a>
					<?else:?>
						<a class="search-result-item" href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a>
					<?endif;?>
			<?endforeach;?>
		<?endforeach;?>
	</div>
	<a href="<?echo $arItem["URL"]?>" class="btn btn-cta">Все результаты</a>
<?endif?>