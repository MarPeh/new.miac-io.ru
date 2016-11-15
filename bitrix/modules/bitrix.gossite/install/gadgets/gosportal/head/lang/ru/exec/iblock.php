<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arIBlockList = array();

if (CModule::IncludeModule("iblock")) {
  $dbIBlocks = CIBlock::GetList(
    array("NAME" => "ASC"),
    array()
  );
  
  while ($arIBlock = $dbIBlocks->GetNext()) {
    $arIBlockList[$arIBlock["ID"]] = $arIBlock["NAME"];
  }
}
?>