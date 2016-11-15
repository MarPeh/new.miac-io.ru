<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (empty($arResult))return;
?>
<div class="block">
<div class="title_menu">
                            	<h2><?=array_shift($GLOBALS['TOP_MENU_SELECTED'])?></h2>
</div>
<div class="event1">
<ul class="side">

<?
$previousLevel = 0;
$firstRoot = false;
foreach($arResult as $itemIdex => $arItem):?>

<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
	<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>	
<?endif?>

<?if ($arItem["IS_PARENT"]):
	$countSub=0;?>
	<?if ($arItem["DEPTH_LEVEL"] == 1):?>
		<li <?if ($arItem["SELECTED"]):?>class="selected"<?endif?>>
			<div>	
				<a class="str" href="<?=$arItem["LINK"]?>" <?if($arItem['PARAMS']['HTML_ID']):?>id="<?=$arItem['PARAMS']['HTML_ID']?>"<?endif?>><?=$arItem["TEXT"]?></a>
				<span class="str"></span>				
			</div>		
				<ul>			
	<?else:?>
				<li  class="<?if ($arItem["SELECTED"]):?>selected <?endif?>">					
					<a href="<?=$arItem["LINK"]?>" <?if($arItem['PARAMS']['HTML_ID']):?>id="<?=$arItem['PARAMS']['HTML_ID']?>"<?endif?>><?=$arItem["TEXT"]?></a>					
						<ul>
	<?endif?>
<?else:?>
	<?if ($arItem["PERMISSION"] > "D"):?>
		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li <?if ($arItem["SELECTED"]):?>class="selectedNotParent"<?endif?>>
					<div>
						<a href="<?=$arItem["LINK"]?>" <?if($arItem['PARAMS']['HTML_ID']):?>id="<?=$arItem['PARAMS']['HTML_ID']?>"<?endif?>>							
							<?=$arItem["TEXT"]?>							
						</a>	
					</div>									
			</li>
		<?else:?>			
			<li <?if ($arItem["SELECTED"]):?>class="selectedChild"<?endif?>>	
				<a href="<?=$arItem["LINK"]?>" <?if($arItem['PARAMS']['HTML_ID']):?>id="<?=$arItem['PARAMS']['HTML_ID']?>"<?endif?>>					
					<?=$arItem["TEXT"]?>					
				</a>
			</li>
		<?endif?>
	<?else:?>
		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li <?if ($arItem["SELECTED"]):?>class="selectedNotParent"<?endif?>>				
					<a href="" <?if ($arItem["SELECTED"]):?>class="selected"<?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>">
						<?=$arItem["TEXT"]?>						
					</a>								
			</li>
		<?else:?>
			<li>				
				<a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>">
					<?=$arItem["TEXT"]?>					
				</a>				
			</li>
		<?endif?>
	<?endif;?>
<?endif;

	$previousLevel = $arItem["DEPTH_LEVEL"];
	if ($arItem["DEPTH_LEVEL"] == 1)
		$firstRoot = true;
?>
<?endforeach;
if ($previousLevel > 1):
	echo str_repeat("</ul></li>", ($previousLevel-1));
endif;?>
</ul>
</div>
</div>