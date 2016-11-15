<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CModule::IncludeModule('iblock');

$arResultNew=array();

$arBlk=array();

$munOrderSelected = $APPLICATION->get_cookie("munOrderSelected");
$munOrderSelectedAr=explode(";",$munOrderSelected);

foreach ($arResult['ITEMS'] as $k=>$v) {
	$nfo = CIBlockElement::GetByID($v['ID']);
	$nfo = $nfo->Fetch();
	if ($nfo) {
		$v['DATE_ACTIVE_TO']=$nfo['ACTIVE_TO'];
		$s_id = $v['IBLOCK_SECTION_ID'];
		if (!isset($arBlk[$s_id])) $arBlk[$s_id] = GetIBlockSection($s_id);
		$v['IBLOCK_SECTION_NAME']=$arBlk[$s_id]['NAME'];
		$v['IBLOCK_SECTION_LINK']=$arBlk[$s_id]['SECTION_PAGE_URL'];
	}
	if(in_array($v['ID'], $munOrderSelectedAr))
		$v['selected']=true;
	else
		$v['selected']=false;
		
	$arResultNew[$k]=$v;
}

$arResult['ITEMS']=$arResultNew;