<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$APPLICATION->SetAdditionalCSS('/bitrix/gadgets/gosportal/head/styles.css');


$cache = new CPageCache();
if ($arGadgetParams["CACHE_TIME"] > 0 && !$cache->StartDataCache($arGadgetParams["CACHE_TIME"], 'c' . $arGadgetParams["HEAD"], "gdhead")) {
	return;
}
?>

<?
if (CModule::IncludeModule('iblock')) {
  $dbHead = CIBlockElement::GetList(
    array('SORT' => 'ASC', 'NAME' => 'ASC'),
    array('IBLOCK_CODE' => 'administration', 'ACTIVE' => 'Y', 'ACTIVE_DATE' => 'Y'),
    false,
    array('nTopCount' => 1),
    array('NAME', 'PROPERTY_POST', 'PREVIEW_PICTURE', 'ID')
  );
  
  if ($arHead = $dbHead->GetNext()) {
    if (!empty($arHead['PREVIEW_PICTURE'])) {
      ?>
      <p align="center">
      <a href="/officials/<?=$arHead['ID']?>/"><? echo CFile::ShowImage($arHead['PREVIEW_PICTURE'], 120, 140); ?></a>
      </p>
      <?
    }
    ?>
    <b class="gdhead-name"><a href="/officials/<?=$arHead['ID']?>/"><? echo $arHead['NAME']; ?></a></b>
    <br />
    <? echo $arHead['PROPERTY_POST_VALUE']; ?>
    <?
  }
}
?>

<? if($arGadgetParams["SHOW_URL"]=="Y") { ?>
  <br />
  <a href="/officials/<?=$arHead['ID']?>/">Подробнее</a> <a href="/officials/<?=$arHead['ID']?>/"><img width="7" height="7" border="0" src="/bitrix/components/bitrix/desktop/images/arrows.gif" /></a>
  <br />
<? } ?>

<?$cache->EndDataCache();?>
