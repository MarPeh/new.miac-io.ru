<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$included = CModule::IncludeModuleEx('bitrix.gossite');
if ($included==MODULE_NOT_FOUND) {
	ShowError(GetMessage('GOSSITE_MODULE_NOT_INSTALLED'));
	return;
}
if ($included==MODULE_DEMO_EXPIRED) {
	ShowError(GetMessage('GOSSITE_MODULE_DEMO_EXPIRED'));
	return;
}


$back_url=$_SERVER['REQUEST_URI'];
$tmp_pos=strpos($back_url,"?");
if ($tmp_pos>0)
{
	$back_url=substr($back_url,0,$tmp_pos);
}

$arResult['BACK_URL']=$back_url;


$arParams["FOLDER"]=trim($arParams["FOLDER"]);

/*определение пути*/
$dir = $arParams["FOLDER"];
if(!is_dir($dir)) $dir = $_SERVER['DOCUMENT_ROOT'].$arParams["FOLDER"];

/*если дериктория существует то сканируем в ней файлы*/
if(is_dir($dir)) {
	$files = scandir($dir);
	array_shift($files);
	array_shift($files);
	$arResult['INFORMERS']=$files;
}
else $arResult['PATH_ERROR']=$dir.' - '.GetMessage('T_INF_NO_SUCH_DIR').';<br>';

$arResult['EDIT_FEATURES']=$this->__path."/forms/edit_features.php";


if (file_exists ($dir.".informers.php"))
{
	require_once($dir.".informers.php");
}
else
{
	$handle = fopen($dir.".informers.php", "w");
	fwrite($handle, '<?$informers=array()?>');
	fclose($handle);
	require_once($dir.".informers.php");
}

if ($_GET['INF'])
{
	if ($_GET['new']=="Y")
	{
		$str= $_GET['F_NAME'];
		$handle = fopen($dir.$_GET['INF'], "w");
		fwrite($handle,'');
		fclose($handle);
	}

	$informers[$_GET['INF']]=array
		(
				"NAME"=>$_GET['F_NAME'],
				"DATE"=>$_GET['F_DAT'],
				"SHOW"=>$_GET['F_SHOW'],
		);
	
	
	
	$handle = fopen($dir.".informers.php", "w");
	fwrite($handle, '<?$informers=array(');
	foreach ($informers as $key=>$value)
	{
		if (file_exists ($dir.$key))
		{
			fwrite($handle, "'".$key."'=>array(");
			fwrite($handle, "'NAME'=>'".$value['NAME']."',");
			fwrite($handle, "'DATE'=>'".$value['DATE']."',");
			fwrite($handle, "'SHOW'=>'".$value['SHOW']."',");
			fwrite($handle, "),");
		}
	}
	fwrite($handle, ')?>');
	fclose($handle);
	LocalRedirect($arResult['BACK_URL']."?clear_cache=Y");
}


if ($_GET['del'])
{
	unlink ($dir.$_GET['del']);
	
	$informers[$_GET['INF']]=array
	(
			"NAME"=>$_GET['F_NAME'],
			"DATE"=>$_GET['F_DAT'],
			"SHOW"=>$_GET['F_SHOW'],
	);



	$handle = fopen($dir.".informers.php", "w");
	fwrite($handle, '<?$informers=array(');
	foreach ($informers as $key=>$value)
	{
		if (file_exists ($dir.$key))
		{
			fwrite($handle, "'".$key."'=>array(");
			fwrite($handle, "'NAME'=>'".$value['NAME']."',");
			fwrite($handle, "'DATE'=>'".$value['DATE']."',");
			fwrite($handle, "'SHOW'=>'".$value['SHOW']."',");
			fwrite($handle, "),");
		}
	}
	fwrite($handle, ')?>');
	fclose($handle);
	LocalRedirect($arResult['BACK_URL']."?clear_cache=Y");
}


foreach ($arResult['INFORMERS'] as $iKey=>$file_name)
{
	if ($file_name==".informers.php")
	{
		unset($arResult['INFORMERS'][$iKey]);
	}
	if ($file_name=="images")
	{
		unset($arResult['INFORMERS'][$iKey]);
	}
	
	if (strtolower(substr($file_name,-4))!=".php")
	{
		unset($arResult['INFORMERS'][$iKey]);
	}
}


foreach ($arResult['INFORMERS'] as $iKey=>$file_name)
{
	$arResult['INFORMERS'][$iKey]=array(
			"FILE"=>$file_name,
	);

	foreach ($informers[$file_name] as $pKey=>$pValue)
	{
		$arResult['INFORMERS'][$iKey][$pKey]=$pValue;
	}

}

$tmp_url= $arResult['EDIT_FEATURES'].'?file=informer'.strtotime(date('d.m.Y H:i:s')).'.php&path='.$arParams["FOLDER"].'&back='.$arResult['BACK_URL'].'&new=Y';
//echo $tmp_url;
$add_inf_link="javascript:(new BX.CAdminDialog({'content_url':'".$tmp_url."','width':'500','height':'400'})).Show()";


$this->AddIncludeAreaIcon(
		array(
				'URL'   => $add_inf_link,
				'TITLE' => GetMessage("T_INF_ADD"),
				'ICON'=>"bx-context-toolbar-create-icon",
		)
);

$this->IncludeComponentTemplate();
?>
