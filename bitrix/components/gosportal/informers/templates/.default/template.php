<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<script type="text/javascript">

if(window.jQuery==undefined) { 
document.write(unescape("%3Cscript src='js/jquery-1.8.3.min.js' type='text/javascript'%3E%3C/script%3E")); 
document.write(unescape("%3Cscript src='js/jquery.jcarousel.min.js' type='text/javascript'%3E%3C/script%3E"));
} 

	$(document).ready(function(){
    	$('#jq-carousel-informer').jcarousel({
    		scroll: 1,
    		wrap: 'both'
    	});
	});
	
	var str = " 1 ";
	str = jQuery.trim(str);
</script>

<?
//echo $APPLICATION->GetCurPage();
?>

<div id="informer">
	<ul id="jq-carousel-informer">
	<?$i=0;
	foreach ($arResult['INFORMERS'] as $informer)
	{
		$i=$i+1;
		$url="/bitrix/admin/public_file_edit.php?lang=".LANGUAGE_ID."&from=main.include&path=".$arParams["FOLDER"].$informer['FILE']."&new=N&template=file_inc.php&site=s1&back_url=".$APPLICATION->GetCurPage()."?bitrix_include_areas=Y&clear_cache=Y&templateID=".urlencode($arParams["EDIT_TEMPLATE"]).$editor;
		$this->AddEditAction("inf_".$i, $url, GetMessage("T_INF_CONTENT_EDIT"), "ELEMENT_EDIT");
		$this->AddEditAction("inf_".$i, $arResult['EDIT_FEATURES'].'?file='.$informer['FILE'].'&path='.$arParams["FOLDER"].'&back='.$arResult['BACK_URL'], GetMessage("T_INF_FEATURES_EDIT"), "ELEMENT_EDIT");
		$this->AddDeleteAction("inf_".$i, $arResult['BACK_URL']."?del=".$informer['FILE'], GetMessage("T_INF_DELETE"), array("CONFIRM" => GetMessage('T_INF_DEL_CONFIRM')));
	?>
		<li id="<?=$this->GetEditAreaId("inf_".$i);?>">
			<div class="head">
				<span><?=$informer['NAME']?></span>
				<p class="separator">/</p>
				<p class="date"><?=$informer['DATE']?></p>
			</div>
			<div class="informer_content">
            	<div>
				<?
					$APPLICATION->IncludeComponent("gosportal:main.include", "", array(
			 		"AREA_FILE_SHOW" => "file", 
			 		"PATH" => $arParams["FOLDER"].$informer['FILE']),
			 		false);
				?>
				</div>
			</div>
		</li>
	<?}?>
	</ul>
</div>