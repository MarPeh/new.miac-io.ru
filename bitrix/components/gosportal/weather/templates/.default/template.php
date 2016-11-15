<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<h3><?=$arResult["CITY_NAME"]?></h3>

<table width="90%">
<tr>
<td nowrap="yes" width="20%"><span class="t<?=$arResult["CLASS"]?>"><?=$arResult["TEMPERATURE"]?></span></td>
<td width="20%" style="padding-right: 5px;"><img src="<?=$arResult["WEATHER_PICTURE"]?>" class="gdwico"></td>
<td width="60%">

<span class="gdweather"><?=$arResult["WEATHER_TYPE"]?></span><br/>
<span class="gdwinfo">

<?=GetMessage("WIND")?>: <?=$arResult["WIND_DIRECTION"]?>, <?=$arResult["WIND_SPEED"]?> <?=GetMessage("WIND_SPEED")?> <br/>

<?=GetMessage("PRESSURE")?>: <?=$arResult["PRESSURE"]?> <?=GetMessage("PRESSURE_ED")?><br/>

<?=GetMessage("DAMPNESS")?>: <?=$arResult["DAMPNESS"]?>%<br/>

<?=GetMessage("SUN_RISE")?>: <?=$arResult["SUN_RISE"]?><br/>

<?=GetMessage("SUN_SET")?>: <?=$arResult["SUN_SET"]?>

</span>
</td>
</tr>

<?if($arResult["TONIGHT"]):?>
<tr>
<td><?=GetMessage("TONIGHT")?>:</td>
<td colspan="2"><?=$arResult["TONIGHT"]?>°C</td>
</tr>
<?endif?>

<?if($arResult["TOMORROW"]):?>
<tr>
<td><?=GetMessage("TOMORROW")?>:</td>
<td colspan="2"><?=$arResult["TOMORROW"]?>°C</td>
</tr>
<?endif?>
</table>

<?if($arParams["SHOW_URL"]=="Y"):?>
	<br />
	<a href="<?=$arResult["DETAIL_URL"]?>"><?=GetMessage("DETAIL_URL")?></a> 
	<a href="<?=$arResult["DETAIL_URL"]?>"><img width="7" height="7" border="0" src="/bitrix/components/bitrix/desktop/images/arrows.gif" /></a>
	<br />
<?endif?>