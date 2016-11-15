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
?>
<?$can_view_counter = $APPLICATION->IncludeComponent("gosportal:show_counter", "", array(), $component);?>
<script type="text/javascript">
	function run(elId) {
		BX.ajax.get('<?=$arParams["SEF_FOLDER"]?>addToSelected.php', {'addToSelected': elId, 'ajax': 'Y'}, PutData);
	}
	function PutData(data) {
		data = eval("(" + data + ")");
		//var data = eval("(" + data + ")");
		if (data.type == 'del') {
			document.getElementById('addToSelected' + data.ID).innerHTML = '<?=GetMessage("ADD_TO_SELECTED")?>';
			<?if($_REQUEST['selected'] == "Y"):?>
			document.getElementById('addToSelected' + data.ID).parentNode.style.display = 'none';
			if (data.count == 0) {
				document.getElementById('newsList').innerHTML = '<p><?=GetMessage("EMPTY_SELECTED")?></p>';
				document.getElementById('clearSelected').style.display = 'none';
			}
			<?endif?>
		}
		else {
			document.getElementById('addToSelected' + data.ID).innerHTML = '<?=GetMessage("DEL_FROM_SELECTED")?>';
		}
		if (document.getElementById('munOrderSelectedMenu') != null)
			document.getElementById('munOrderSelectedMenu').innerHTML = '<?=GetMessage("SELECTED_MENU")?> (' + data.count + ')';
	}
</script>
<div class="news" id="newsList">
	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?><br />
	<?endif;?>

	<?if($_REQUEST['SECTION_ID']):?>
		<span style="font-size:0.8em;"><a href=""></a></span>
	<?endif?>
	<?foreach($arResult["ITEMS"] as $arItem):
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="news-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
				<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img  border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["NAME"]?>" /></a>
				<?else:?>
					<img  border="0" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["NAME"]?>"  />
				<?endif;?>
			<?endif?>

			<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
				<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
					<p class="h3"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></p>
				<?else:?>
					<p class="h3"><?echo $arItem["NAME"]?></p>
				<?endif;?>
			<?endif;?>
			<?if($arParams["DISPLAY_DATE"]!="N"):
				$arr = ParseDateTime($arItem['ACTIVE_FROM'], FORMAT_DATETIME);
				$arItem["DISPLAY_ACTIVE_FROM"]=(int)$arr["DD"]." ".ToLower(GetMessage("MONTH_".intval($arr["MM"])."_S"))." ".$arr["YYYY"];?>
				<p class="date">
					<?if($arItem["DISPLAY_ACTIVE_FROM"]):?>
						<?=GetMessage("RAZMESHENA")?><?echo $arItem["DISPLAY_ACTIVE_FROM"]?>.
					<?endif?>
					<?if($arItem["DATE_ACTIVE_TO"]):
						$arr = ParseDateTime($arItem['DATE_ACTIVE_TO'], FORMAT_DATETIME);
						$arItem["DATE_ACTIVE_TO"]=(int)$arr["DD"]." ".ToLower(GetMessage("MONTH_".intval($arr["MM"])."_S"))." ".$arr["YYYY"];?>
						<?=GetMessage("OKONCHANIE")?><?echo $arItem["DATE_ACTIVE_TO"]?>.
					<?endif?>
				</p>
			<?endif?>
			<? $frame = $this->createFrame()->begin('Загрузка'); ?>
			<a href="<?=$APPLICATION->GetCurPageParam("addToSelected=".$arItem['ID'], array("addToSelected"))?>" id="addToSelected<?=$arItem['ID']?>" class="addToSelected" onclick="run(<?=$arItem['ID']?>);return false;">
				<?if($arItem['selected'])
					echo GetMessage("DEL_FROM_SELECTED");
				else
					echo GetMessage("ADD_TO_SELECTED");
				?>
			</a>
			<? $frame->end(); ?>
			<br/>
			<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
				<p><?echo $arItem["PREVIEW_TEXT"];?></p>
			<?endif;?>
			<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
				<small>
					<?=$arProperty["NAME"]?>: 
					<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
						<?=implode(" / ", $arProperty["DISPLAY_VALUE"]);?>
					<?else:?>
						<?=$arProperty["DISPLAY_VALUE"];?>
					<?endif?>
				</small><br />
			<?endforeach;
			foreach($arItem["FIELDS"] as $code=>$value):
				if($code!="SHOW_COUNTER" || ($code=="SHOW_COUNTER" && $can_view_counter)):?>
					<small>
						<?=GetMessage("IBLOCK_FIELD_".$code)?>: <?=$code!="SHOW_COUNTER"?$value:intval($value);?>
					</small><br />
				<?endif;
			endforeach;?>
		</div>
	<?endforeach;?>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<br /><?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>
<div class="clearfix"></div>