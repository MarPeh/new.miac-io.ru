<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
function formatFileSize($bytes) 
{
            if (!is_numeric($bytes) || !$bytes) {
                return '';
            }
            if ($bytes >= 1000000000) {
                return round($bytes / 1000000000,2).' '.GetMessage("GB");
            }
            if ($bytes >= 1000000) {
                return round($bytes / 1000000,2).' '.GetMessage("MB");
            }
            return round($bytes / 1000,2). ' '.GetMessage("KB");
}

function human_plural_form($number, $titles)
{
    $cases = array (2, 0, 1, 1, 1, 2);
    return $number." ".$titles[ ($number%100 >4 && $number%100< 20)? 2 : $cases[min($number%10, 5)] ];
}
?>
<?$can_view_counter = $APPLICATION->IncludeComponent("gosportal:show_counter", "", array(), $component);?>
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
<div class="news-list">
<?foreach($arResult["ITEMS"] as $arItem):
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
	<div id="<?=$this->GetEditAreaId($arItem['ID']);?>" class="news-item">
		<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):
			$arr = ParseDateTime($arItem['ACTIVE_FROM'], FORMAT_DATETIME);
			$arItem["DISPLAY_ACTIVE_FROM"]=(int)$arr["DD"]." ".ToLower(GetMessage("MONTH_".intval($arr["MM"])."_S"))." ".$arr["YYYY"];?>
			<div class="news-item-date"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></div>
		<?endif?>
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
            <div class="news-item-image">
			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" /></a>
			<?else:?>
				<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
			<?endif;?>
            </div>
		<?endif?>
        <div class="news-item-text">
		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
			<h3 class="news-item-header">
            <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
				<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
			<?else:?>
				<?echo $arItem["NAME"]?>
			<?endif;?>
            </h3>
		<?endif;?>
		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
			<p><?echo $arItem["PREVIEW_TEXT"];?></p>
		<?endif;?>
        </div>

		<?if(is_array($arItem["DISPLAY_PROPERTIES"]['FILE']["DISPLAY_VALUE"])):
			foreach($arItem["DISPLAY_PROPERTIES"]['FILE']["DISPLAY_VALUE"] as $key=>$value):				
				$ext=substr($arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC'], strrpos($arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC'], '.') + 1);?>
				<div class="files-download">
					<a class="<?=$ext?>" href="/bitrix/redirect.php?event1=file&event2=download&event3=<?=$arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['FILE_NAME']?>&goto<?=$arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['SRC']?>" title="<?=GetMessage("DOWNLOAD")?> <?=$arResult["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['DESCRIPTION']?>">
						<span><?=GetMessage("DOWNLOAD")?></span>
					</a> 				
					<span class="file_prop">(<?=formatFileSize($arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['FILE_SIZE'])?>, <?=$ext?>)
				
				<?if (CModule::IncludeModule("statistic")):
					$rs = CStatEvent::GetList(
						 ($by = "s_id"), 
    						($order = "desc"), 
						 array(
						 		'EVENT1'=>"file",
						 		"EVENT1_EXACT_MATCH"=>"Y",
						 		'EVENT2'=>"download",
						 		"EVENT2_EXACT_MATCH"=>"Y",
						 		"EVENT3"=>$arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE'][$key]['FILE_NAME'],
						 		"EVENT3_EXACT_MATCH"=>"Y"),
						 $is_filtered
						);
					echo GetMessage("DOWNLOAD_COUNT").human_plural_form($rs->SelectedRowsCount(), array(GetMessage("RAZ"),GetMessage("RAZA"),GetMessage("RAZ")));
				endif?>
				</span>
			</div>
			<?endforeach;
		elseif($arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']):
			$ext=substr($arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], strrpos($arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC'], '.') + 1);?>
			<div class="files-download">
				<a class="<?=$ext?>" href="/bitrix/redirect.php?event1=file&event2=download&event3=<?=$arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['FILE_NAME']?>&goto=<?=$arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['SRC']?>" title="<?=GetMessage("DOWNLOAD")?> <?=$arItem["NAME"]?>">
					<span><?=GetMessage("DOWNLOAD")?></span>
				</a>			
				<span class="file_prop">(<?=formatFileSize($arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['FILE_SIZE'])?>, <?=$ext?>)	
			
			<?if (CModule::IncludeModule("statistic")):
					$rs = CStatEvent::GetList(
						($by = "s_id"), 
    						($order = "desc"), 
						 array(
						 		'EVENT1'=>"file",
						 		"EVENT1_EXACT_MATCH"=>"Y",
						 		'EVENT2'=>"download",
						 		"EVENT2_EXACT_MATCH"=>"Y",
						 		"EVENT3"=>$arItem["DISPLAY_PROPERTIES"]['FILE']['FILE_VALUE']['FILE_NAME'],
						 		"EVENT3_EXACT_MATCH"=>"Y"),
						 $is_filtered
						);
					echo GetMessage("DOWNLOAD_COUNT").human_plural_form($rs->SelectedRowsCount(), array(GetMessage("RAZ"),GetMessage("RAZA"),GetMessage("RAZ")));
				endif?>	
				</span>
			</div>
		<?endif;?>
		<p>
		<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):
			if($pid!="FILE"):?>
				<small>
				<?=$arProperty["NAME"]?>:&nbsp;
				<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
					<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
				<?else:?>
					<?=$arProperty["DISPLAY_VALUE"];?>
				<?endif?>
				</small><br />
			<?endif?>
		<?endforeach;
		foreach($arItem["FIELDS"] as $code=>$value):
			if($code!="SHOW_COUNTER" || ($code=="SHOW_COUNTER" && $can_view_counter)):?>
				<small>
				<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$code!="SHOW_COUNTER"?$value:intval($value);?>
				</small><br />
			<?endif;
		endforeach;?>
		</p>
	</div>
<?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>