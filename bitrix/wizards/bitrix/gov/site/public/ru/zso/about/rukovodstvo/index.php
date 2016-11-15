<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Руководство");
?><?
$APPLICATION->IncludeComponent("gosportal:staff", "", array(
	"IBLOCK_TYPE" => 'structure',
	"IBLOCK_ID" => '#STRUCTURE_IBLOCK_ID#'
),
	false
);
?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>