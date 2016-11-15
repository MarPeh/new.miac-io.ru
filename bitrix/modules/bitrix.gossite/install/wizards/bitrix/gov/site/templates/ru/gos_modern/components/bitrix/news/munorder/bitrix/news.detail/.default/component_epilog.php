<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

__IncludeLang($_SERVER["DOCUMENT_ROOT"].$templateFolder."/lang/".LANGUAGE_ID."/template.php");

$munOrderSelected = $APPLICATION->get_cookie("munOrderSelected");
$munOrderSelectedAr=explode(";",$munOrderSelected);
$count=count($munOrderSelectedAr)-1;
if(in_array($arResult['ID'], $munOrderSelectedAr))
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
<script type="text/javascript">
BX.ready(function(){
		document.getElementById('addToSelected<?=$arResult['ID']?>').innerHTML='<?=$text?>';
		document.getElementById('munOrderSelectedMenu').innerHTML='<?=GetMessage("SELECTED_MENU")?> (<?=$count?>)';
});
</script>
