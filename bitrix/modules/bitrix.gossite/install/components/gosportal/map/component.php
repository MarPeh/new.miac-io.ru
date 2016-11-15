<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$included = CModule::IncludeModuleEx('bitrix.gossite');
if ($included==MODULE_NOT_FOUND) {
	ShowError(GetMessage('GOSSITE_MODULE_NOT_INSTALLED'));
	return;
}
if ($included==MODULE_DEMO_EXPIRED) {
	ShowError(GetMessage('GOSSITE_MODULE_DEMO_EXPIRED'));
	return;
}


$arParams["NEWS_COUNT"] = $arParams["ELEMENTS_COUNT"];

if(empty($arParams["DATA_TYPE"])){
	$arParams["DATA_TYPE"] = "objects";
}

$this->IncludeComponentTemplate();