<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->SetTitle(str_replace("[".SITE_ID."]", "", $arResult['NAME']));
__IncludeLang($_SERVER["DOCUMENT_ROOT"].$templateFolder."/lang/".LANGUAGE_ID."/template.php");

$munOrderSelected = $APPLICATION->get_cookie("munOrderSelected");
$munOrderSelectedAr=explode(";",$munOrderSelected);
$count=count($munOrderSelectedAr)-1;

?>
<script type="text/javascript">
<?
foreach($arResult['ELEMENTS']  as $arItem):
	if(in_array($arItem, $munOrderSelectedAr))
	{
			$selected=true;
			$text=GetMessage("DEL_FROM_SELECTED");			
	}
	else
	{
			$selected=false;
			$text=GetMessage("ADD_TO_SELECTED");
	}
	?>	
	document.getElementById('addToSelected<?=$arItem?>').innerHTML='<?=$text?>';				
<?endforeach;?>
BX.ready(function(){
if (document.getElementById('munOrderSelectedMenu')!=null)
	document.getElementById('munOrderSelectedMenu').innerHTML='<?=GetMessage("SELECTED_MENU")?> (<?=$count?>)';
});
</script>


