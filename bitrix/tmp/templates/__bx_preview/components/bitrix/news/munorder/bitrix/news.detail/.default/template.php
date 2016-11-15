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
<script type="text/javascript">
	function run(elId) {
		BX.ajax.get('<?=$arParams["SEF_FOLDER"]?>addToSelected.php', {'addToSelected': elId, 'ajax': 'Y'}, PutData);
	}
	function PutData(data) {
		var data = eval("(" + data + ")");
		if (data.type == 'del')
			document.getElementById('addToSelected' + data.ID).innerHTML = '<?=GetMessage("ADD_TO_SELECTED")?>';
		else
			document.getElementById('addToSelected' + data.ID).innerHTML = '<?=GetMessage("DEL_FROM_SELECTED")?>';

		document.getElementById('munOrderSelectedMenu').innerHTML = '<?=GetMessage("SELECTED_MENU")?> (' + data.count + ')';
	}
</script>
<div class="news">

<div class="news-item">
	<?if($arParams["DISPLAY_DATE"]!="N"):?>
		<?if($arResult["DISPLAY_ACTIVE_FROM"]):
			$arr = ParseDateTime($arResult['ACTIVE_FROM'], FORMAT_DATETIME);
			$arResult["DISPLAY_ACTIVE_FROM"]=(int)$arr["DD"]." ".ToLower(GetMessage("MONTH_".intval($arr["MM"])."_S"))." ".$arr["YYYY"];?>
			<p class="date"><?=GetMessage("PUB_DATE")?><?=$arResult["DISPLAY_ACTIVE_FROM"]?></p>
		<?endif;?>
		<?if($arResult["DATE_ACTIVE_TO"]):
			$arr = ParseDateTime($arResult['DATE_ACTIVE_TO'], FORMAT_DATETIME);
			$arResult["DATE_ACTIVE_TO"]=(int)$arr["DD"]." ".ToLower(GetMessage("MONTH_".intval($arr["MM"])."_S"))." ".$arr["YYYY"];?>
			<p class="date"><?=GetMessage("PUB_DATE_FINISH")?><?=$arResult["DATE_ACTIVE_TO"]?></p>
		<?endif;?>
	<?endif;?>
	<?if($arResult["IBLOCK_SECTION_NAME"]):?>
		<p class="date"><?=GetMessage("VID")?> <?=$arResult["IBLOCK_SECTION_NAME"]?></p>
	<?endif?>
	<br/>
	<a href="<?=$APPLICATION->GetCurPageParam("addToSelected=".$arResult['ID'], array("addToSelected"))?>" id="addToSelected<?=$arResult['ID']?>" class="addToSelected" onclick="run(<?=$arResult['ID']?>);return false;">
			<?if($arResult['selected'])
				echo GetMessage("DEL_FROM_SELECTED");
			else
				echo GetMessage("ADD_TO_SELECTED");
			?>						
	</a>
	<br/>
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"  title="<?=$arResult["NAME"]?>" />
	<?endif?>	
	<?if($arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"] && false):?>
		<h3><?=$arResult["NAME"]?></h3>
	<?endif;?>
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
		<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
	<?endif;?>
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
 	<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
		<p><?echo $arResult["DETAIL_TEXT"];?></p>
 	<?else:?>
		<p><?echo $arResult["PREVIEW_TEXT"];?></p>
	<?endif?>

	<table class="table table-bordered table-responsive">
	<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
		<tr><th colspan='2'><b><?=$arProperty["NAME"]?></b></th></tr>
		<?
			$el_dis = explode("\r\n",$arProperty["DISPLAY_VALUE"]);
			foreach ($el_dis as $el_el):
				if (trim($el_el)!='') {
					list($el_title,$el_text)=explode(':',$el_el,2);
					$el_title = trim($el_title);
					$el_text = trim($el_text);
		?>
		<tr>
		<?if(!empty($el_text)):?>
			<td class="details-left-col">
				<?=TxtToHtml($el_title)?>
			</td>
			<td class="details-right-col">
				<?= in_array($pid,array('DOCS','COTIR','PROJECT')) ? $el_text : TxtToHtml($el_text)?>
			</td>
		<?else:?>
			<td class="details-right-col" colspan="2">
				<?= in_array($pid,array('DOCS','COTIR','PROJECT')) ? $el_title : TxtToHtml($el_title)?>
			</td>
		<?endif;?>
		</tr>
	<?
				}
			endforeach;
	?>
	<?endforeach;?>
	</table>
	<?foreach($arResult["FIELDS"] as $code=>$value):?>
				<br /><small>
				<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$code!="SHOW_COUNTER"?$value:intval($value);?>
				</small>
	<?endforeach;?>	
</div>

</div>