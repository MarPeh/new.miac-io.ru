<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Визуальная структура");
?>
<?
$APPLICATION->IncludeComponent("gosportal:structure.visual", ".default", array(
    "IBLOCK_TYPE" => "structure",
    "IBLOCK_ID" => "#STRUCTURE_IBLOCK_ID#"
),
    false
);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>