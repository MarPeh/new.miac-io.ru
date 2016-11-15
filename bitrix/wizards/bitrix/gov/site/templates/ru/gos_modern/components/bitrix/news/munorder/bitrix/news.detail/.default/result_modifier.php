<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

function prepare_file_property($prop_name,$arResult) {

	if($arResult['PROPERTIES'][$prop_name]['VALUE']):
		if (is_array($arResult['PROPERTIES'][$prop_name]['VALUE'])):
			$elems = array();
			foreach ($arResult['PROPERTIES'][$prop_name]['VALUE'] as $k=>$f_id) {
				$descr = $arResult['PROPERTIES'][$prop_name]['DESCRIPTION'][$k];
				$file_array = CFile::GetFileArray($f_id);
				$link=$file_array['SRC'];
				if (empty($descr)) $descr=$file_array['DESCRIPTION'];
				if (empty($descr)) $descr=basename($link);
				$elems[]="<a href='$link'>$descr</a>";
			}
			$arResult['DISPLAY_PROPERTIES'][$prop_name]['DISPLAY_VALUE']='Файлы:'.implode('<br/>',$elems);
		else:
			$descr = $arResult['PROPERTIES'][$prop_name]['DESCRIPTION'];
			$file_array = CFile::GetFileArray($arResult['PROPERTIES'][$prop_name]['VALUE']);
			$link=$file_array['SRC'];
			if (empty($descr)) $descr=$file_array['DESCRIPTION'];
			if (empty($descr)) $descr=basename($link);
			$elems="<a href='$link'>$descr</a>";
			$arResult['DISPLAY_PROPERTIES'][$prop_name]['DISPLAY_VALUE']='Файл:'.$elems;
		endif;
		$arResult['DISPLAY_PROPERTIES'][$prop_name]['NAME']=$arResult['PROPERTIES'][$prop_name]['NAME'];
	endif;
	return $arResult;
}

$arResult = prepare_file_property('DOCS',$arResult);
$arResult = prepare_file_property('COTIR',$arResult);
$arResult = prepare_file_property('PROJECT',$arResult);

$nfo = CIBlockElement::GetByID($arResult['ID']);
$nfo = $nfo->Fetch();
$arResult['DATE_ACTIVE_TO']=$nfo['ACTIVE_TO'];

if ($arResult['IBLOCK_SECTION_ID']):
	$nfo = GetIBlockSection($arResult['IBLOCK_SECTION_ID']);
	$arResult['IBLOCK_SECTION_NAME']=$nfo['NAME'];
endif;

$munOrderSelected = $APPLICATION->get_cookie("munOrderSelected");
$munOrderSelectedAr=explode(";",$munOrderSelected);
if(in_array($arResult['ID'], $munOrderSelectedAr))
		$arResult['selected']=true;
	else
		$arResult['selected']=false;