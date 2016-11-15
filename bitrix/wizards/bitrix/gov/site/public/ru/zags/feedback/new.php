<?
define('hide_official_menu',true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Обращения граждан");$APPLICATION->SetPageProperty("show_timestamp_x", "N");
$APPLICATION->AddChainItem("Обращения граждан", "");
?>

<?$APPLICATION->IncludeComponent("bitrix:form.result.new", "internet_reception", Array(
	"SEF_MODE" => "N",	// Включить поддержку ЧПУ
	"WEB_FORM_ID" => "#internet_reception_form_id#",	// ID веб-формы
	"LIST_URL" => "",	// Страница со списком результатов
	"EDIT_URL" => "",	// Страница редактирования результата
	"SUCCESS_URL" => "",	// Страница с сообщением об успешной отправке
	"CHAIN_ITEM_TEXT" => "",	// Название дополнительного пункта в навигационной цепочке
	"CHAIN_ITEM_LINK" => "",	// Ссылка на дополнительном пункте в навигационной цепочке
	"IGNORE_CUSTOM_TEMPLATE" => "Y",	// Игнорировать свой шаблон
	"USE_EXTENDED_ERRORS" => "N",	// Использовать расширенный вывод сообщений об ошибках
	"CACHE_TYPE" => "A",	// Тип кеширования
	"CACHE_TIME" => "3600",	// Время кеширования (сек.)
	"VARIABLE_ALIASES" => array(
		"WEB_FORM_ID" => "WEB_FORM_ID",
		"RESULT_ID" => "RESULT_ID",
	)
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>