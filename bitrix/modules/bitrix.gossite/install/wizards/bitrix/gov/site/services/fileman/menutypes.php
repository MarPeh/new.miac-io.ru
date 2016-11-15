<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CModule::IncludeModule('fileman');
$arMenuTypes['top'] = GetMessage("WIZ_MENU_TOP");
$arMenuTypes['left'] = GetMessage("WIZ_MENU_LEFT");
$arMenuTypes['important'] = GetMessage("WIZ_MENU_IMPORTANT");
$arMenuTypes['info'] = GetMessage("WIZ_MENU_INFO");
$arMenuTypes['social'] = GetMessage("WIZ_MENU_SOCIAL");
$arMenuTypes['sidebar'] = GetMessage("WIZ_MENU_SIDEBAR");

SetMenuTypes($arMenuTypes, WIZARD_SITE_ID);