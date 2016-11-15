<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Результаты анкетирования");$APPLICATION->SetPageProperty("show_timestamp_x", "N");
?><?$APPLICATION->IncludeComponent(
	"bitrix:form.result.list",
	"",
	Array(
		"SEF_MODE" => "N",
		"WEB_FORM_ID" => "1",
		"VIEW_URL" => "",
		"EDIT_URL" => "",
		"NEW_URL" => "index.php",
		"SHOW_ADDITIONAL" => "N",
		"SHOW_ANSWER_VALUE" => "N",
		"SHOW_STATUS" => "Y",
		"NOT_SHOW_FILTER" => Array(),
		"NOT_SHOW_TABLE" => Array(),
		"CHAIN_ITEM_TEXT" => "",
		"CHAIN_ITEM_LINK" => ""
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>