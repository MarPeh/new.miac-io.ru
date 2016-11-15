<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$included = CModule::IncludeModuleEx('bitrix.gossite');
if ($included==MODULE_NOT_FOUND) {
	ShowError(GetMessage('GOSSITE_MODULE_NOT_INSTALLED'));
	return;
}
if ($included==MODULE_DEMO_EXPIRED) {
	ShowError(GetMessage('GOSSITE_MODULE_DEMO_EXPIRED'));
	return;
}

$arParams['NAME_TEMPLATE'] = $arParams['NAME_TEMPLATE'] ? $arParams['NAME_TEMPLATE'] : GetMessage("INTR_ISP_NAME_TEMPLATE_DEFAULT");
$bUseLogin = $arParams['SHOW_LOGIN'] != "N" ? true : false;
$arResult["bUseLogin"] = $bUseLogin;
	
$arResult['CAN_EDIT_USER'] = false;
if ($USER->CanDoOperation('edit_all_users'))
{
	$arResult['CAN_EDIT_USER'] = true;
}
elseif ($USER->CanDoOperation('edit_subordinate_users'))
{
	$arUserGroups = CUser::GetUserGroup($arParams["USER"]['ID']);
	if (array_key_exists("SONET_SUBORD_GROUPS_BY_USER_ID", $GLOBALS) && array_key_exists($GLOBALS["USER"]->GetID(), $GLOBALS["SONET_SUBORD_GROUPS_BY_USER_ID"]))
	{
		$arUserSubordinateGroups = $GLOBALS["SONET_SUBORD_GROUPS_BY_USER_ID"][$GLOBALS["USER"]->GetID()];
	}
	else
	{
		$arUserSubordinateGroups = array(2);
		$arUserGroups_u = CUser::GetUserGroupArray();
		for ($j = 0, $len = count($arUserGroups_u); $j < $len; $j++)
		{
			$arSubordinateGroups = CGroup::GetSubordinateGroups($arUserGroups_u[$j]);
			$arUserSubordinateGroups = array_merge($arUserSubordinateGroups, $arSubordinateGroups);
		}
		$arUserSubordinateGroups = array_unique($arUserSubordinateGroups);

		if (!array_key_exists("SONET_SUBORD_GROUPS_BY_USER_ID", $GLOBALS))
		{
			$GLOBALS["SONET_SUBORD_GROUPS_BY_USER_ID"] = array();
		}
		$GLOBALS["SONET_SUBORD_GROUPS_BY_USER_ID"][$GLOBALS["USER"]->GetID()] = $arUserSubordinateGroups;
	}
	if (count(array_diff($arUserGroups, $arUserSubordinateGroups)) == 0)
	{
		$arResult['CAN_EDIT_USER'] = true;
	}
}

$arResult['USER_PROP'] = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("USER", 0, LANGUAGE_ID);

$arResult['CAN_MESSAGE'] = false;
$arResult['CAN_VIDEO_CALL'] = false;
$arResult['CAN_VIEW_PROFILE'] = false;

if (CModule::IncludeModule('socialnetwork') && $GLOBALS["USER"]->IsAuthorized())
{
	$arResult["CurrentUserPerms"] = CSocNetUserPerms::InitUserPerms($GLOBALS["USER"]->GetID(), $arParams["USER"]["ID"], CSocNetUser::IsCurrentUserModuleAdmin());

	if ($arResult["CurrentUserPerms"]["Operations"]["message"])
		$arResult['CAN_MESSAGE'] = true;
		
	if ($arResult["CurrentUserPerms"]["Operations"]["viewprofile"])
		$arResult['CAN_VIEW_PROFILE'] = true;
		
	if ($arResult["CurrentUserPerms"]["Operations"]["videocall"])
		$arResult['CAN_VIDEO_CALL'] = true;
		
	if(!CModule::IncludeModule("video"))
		$arResult['CAN_VIDEO_CALL'] = false;
	elseif(!CVideo::CanUserMakeCall())
		$arResult['CAN_VIDEO_CALL'] = false;
}

$arResult["Urls"]["VideoCall"] = CComponentEngine::MakePathFromTemplate($arParams["PATH_TO_VIDEO_CALL"], array("user_id" => $arParams["USER"]["ID"], "USER_ID" => $arParams["USER"]["ID"], "ID" => $arParams["USER"]["ID"]));

$arResult['Urls']['TooltipCall'] = $APPLICATION->GetCurPageParam("", array("bxajaxid", "logout"));

$this->IncludeComponentTemplate();
?>