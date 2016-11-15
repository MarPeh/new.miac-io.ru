<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

$included = CModule::IncludeModuleEx('bitrix.gossite');
if ($included==MODULE_NOT_FOUND) {
	ShowError(GetMessage('SCHOOLWEBSITE_MODULE_NOT_INSTALLED'));
	return;
}
if ($included==MODULE_DEMO_EXPIRED) {
	ShowError(GetMessage('SCHOOLWEBSITE_MODULE_DEMO_EXPIRED'));
	return;
}
CModule::IncludeModuleEx('iblock');

GLOBAL $CACHE_MANAGER, $APPLICATION;
if (!isset($arParams["CACHE_TIME"]) || intval($arParams["CACHE_TIME"]) == 0)
    $arParams["CACHE_TIME"] = 3600;
if (!empty($arParams['USER_INFO_LINK'])) {
    if (strpos($arParams['USER_INFO_LINK'], '/') !== 0)
        $arParams['USER_INFO_LINK'] = '/'.$arParams['USER_INFO_LINK'];
}
$arCacheCond = array(
    $USER->GetID(),
    date('d.m.Y'),
);
if (!is_array($arParams['USER'])) {
    $arCacheCond[] = $arParams['USER'];
	$cachePath = '/'.SITE_ID.'/medsite/medsite.system.person/'.$arParams['~USER'];
}
else {
    $arCacheCond[] = $arParams['USER']['ID'];
	$cachePath = '/'.SITE_ID.'/medsite/medsite.system.person/'.$arParams['~USER']['ID'];
	if (array_key_exists('work_time', $arParams['USER']))
        $arCacheCond[] = $arParams['USER']['work_time'];
}
if ($arParams["SHOW_WORKFLOW"] || $this->StartResultCache(false, $arCacheCond, $cachePath)) {
    if (!isset($arParams['USER']) || empty($arParams['USER']))
        return;
    if (!is_array($arParams['USER'])) {
        $rsUser = CUser::GetByID($arParams['USER']);

        $arParams['USER'] = $rsUser->GetNext();

		if ($arParams['USER']['UF_STRUCTURE'] > 0) {
			$dbRes = CIBlockSection::GetList(array('SORT' => 'ASC'), array('ID' => $arParams['USER']['UF_STRUCTURE']));
			$arDepartments = array();
			while ($arSect = $dbRes->Fetch()) {
				$arDepartments[$arSect['ID']] = $arSect['NAME'];
			}
		}

        $arParams['~USER'] = $arParams['USER'];
    }
	$rsUField = CUserTypeEntity::GetList(array(),array('ENTITY_ID'=>'USER','FIELD_NAME'=>'UF_STRUCTURE'));
	$arUField = $rsUField->GetNext();

    CModule::IncludeModule('iblock');
    $arParams['NAME_TEMPLATE'] = $arParams['NAME_TEMPLATE'] ? $arParams['NAME_TEMPLATE'] : GetMessage("INTR_ISP_NAME_TEMPLATE_DEFAULT");
    $bUseLogin = $arParams['SHOW_LOGIN'] != "N" ? true : false;
    $arResult["bUseLogin"] = $bUseLogin;
    $arResult['CAN_EDIT_USER'] = $USER->CanDoOperation('edit_all_users');
    $arResult['USER_PROP'] = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("USER", 0, LANGUAGE_ID);
    $arResult['CAN_MESSAGE'] = false;
    $arResult['CAN_VIDEO_CALL'] = false;
    $arResult['CAN_VIEW_PROFILE'] = false;
    $this->IncludeComponentTemplate();
}
?>