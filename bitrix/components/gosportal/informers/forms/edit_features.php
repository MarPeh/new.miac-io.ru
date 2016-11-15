<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once(__DIR__."/../lang/".LANGUAGE_ID."/component.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_js.php");

$informerFile = htmlspecialcharsbx($_GET['file']);
$pathToInformerFile = htmlspecialcharsbx($_GET['path']);
$componentTemplate = htmlspecialcharsbx($_GET["template_id"]);
$srcLine = intval($_GET["src_line"]);
$srcPath = urlencode(CUtil::addslashes($_GET["src_path"]));
$url = htmlspecialcharsbx($_GET['back']);
$new = htmlspecialcharsbx($_GET['new']);
?>

<script type="text/javascript">

function save_features()
{
	s_el=document.getElementById('F_NAME');
	nam=s_el.value;
	

	s_el=document.getElementById('F_DAT');
	dat=s_el.value;

	s_el=document.getElementById('F_SHOW');
	if (s_el.checked==true)
	{
		shw="Y";
	}
	else
	{
		shw="N";
	}
	<?
	?>
	nw="<?=$new?>"
	
	if (nw=="Y")
	{
		document.location.href="<?=$url?>"+"?F_NAME="+nam+"&F_DAT="+dat+"&F_SHOW="+shw+"&INF="+"<?=$informerFile?>"+"&new=Y";
	}
	else
	{
		document.location.href="<?=$url?>"+"?F_NAME="+nam+"&F_DAT="+dat+"&F_SHOW="+shw+"&INF="+"<?=$informerFile?>";
	}
}

function alr()
{
	alert('123');
}

</script>


<style>
.bx-core-dialog-content 
{
	height: 150px !important; 
}
</style>


<?
//echo $_SERVER['REQUEST_URI'];
//echo $informerFile.'<br>', $_SERVER[''] .$pathToInformerFile;
if (file_exists ($_SERVER['DOCUMENT_ROOT'] .$pathToInformerFile.".informers.php"))
{
	require_once($_SERVER["DOCUMENT_ROOT"].$pathToInformerFile.".informers.php");
}
else
{
	$handle = fopen($_SERVER["DOCUMENT_ROOT"].$pathToInformerFile.".informers.php", "w");
	fwrite($handle, '<?$informers=array()?>');
	fclose($handle);
	require_once($_SERVER["DOCUMENT_ROOT"].$pathToInformerFile.".informers.php");
}
?>
  
<div style="margin-left:35px; padding-top:30px;">
	<div style="float:left; width:100px;">
		<?echo GetMessage("T_INF_NAME")?>
	</div>
	<div style="float:left; width:300px;">
		<input style="width:100%" name="NAME" id="F_NAME" type="text" value="<?=$informers[$informerFile]['NAME'];?>">
	</div><br><br>
	<div style="float:left; width:100px;">
		<?echo GetMessage("T_INF_DATE")?>
	</div>
	<div style="float:left; width:300px;">
		<input id="F_DAT" style="width:100%" name="DAT" type="text" value="<?=$informers[$informerFile]['DATE'];?>">
	</div><br><br>
	
	<div style="float:left; width:100px;">
		<?echo GetMessage("T_INF_SHOW")?></div>
	<div style="float:left; width:300px;">
		<?
			$ch="";
			if ($informers[$informerFile]['SHOW']=="Y") $ch="checked";
			if ($new=="Y") $ch="checked";
		?>
		<input id="F_SHOW" name="SHOW" type="checkbox" <?=$ch?> value="Y">
	</div><br><br>
</div>


<?
CUtil::JSPostUnescape();

$obJSPopup = new CJSPopup('',
	array(
		'TITLE' => GetMessage("T_INF_CAPT"),
		'ARGS' => 'path='.urlencode(CUtil::addslashes($pathToInformerFile)).
				'&amp;template_id='.urlencode(CUtil::addslashes($componentTemplate)).
				'&amp;lang='.LANGUAGE_ID.
				'&amp;src_path='.$srcPath.
				'&amp;src_line='.$srcLine.
				'&amp;action=save'
	)
);

$obJSPopup->ShowTitlebar();

$strWarning = "";
$arValues = array();
$arTemplate = false;
$aComponent = false;

$io = CBXVirtualIo::GetInstance();
$obJSPopup->StartContent();

$obJSPopup->StartButtons();
//echo '<input id="btn_popup_save" name="btn_popup_save" type="button" value="'.GetMessage("JSPOPUP_SAVE_CAPTION").'" onclick="'.$obJSPopup->jsPopup.'.PostParameters(\'action=save\');" title="'.GetMessage("JSPOPUP_SAVE_CAPTION").'" />'."\r\n";
echo '<input id="btn_popup_save" name="btn_popup_save" type="button" value="'.GetMessage("JSPOPUP_SAVE_CAPTION").'" onclick="save_features()" />'."\r\n";
$obJSPopup->ShowStandardButtons(array('close'));

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin_js.php");
?>