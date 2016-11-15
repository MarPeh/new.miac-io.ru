<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$included = CModule::IncludeModuleEx('bitrix.gossite');
if ($included==MODULE_NOT_FOUND) {
	ShowError(GetMessage('SCHOOLWEBSITE_MODULE_NOT_INSTALLED'));
	return;
}
if ($included==MODULE_DEMO_EXPIRED) {
	ShowError(GetMessage('SCHOOLWEBSITE_MODULE_DEMO_EXPIRED'));
	return;
}

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
if(strlen($arParams["IBLOCK_TYPE"])<=0)
	$arParams["IBLOCK_TYPE"] = "news";
$arParams["IBLOCK_ID"] = trim($arParams["IBLOCK_ID"]);

if($this->StartResultCache(false, array(($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups()))))
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	if(is_numeric($arParams["IBLOCK_ID"]))
	{
		$rsIBlock = CIBlock::GetList(array(), array(
			"ACTIVE" => "Y",
			"ID" => $arParams["IBLOCK_ID"],
		));
	}
	else
	{
		$rsIBlock = CIBlock::GetList(array(), array(
			"ACTIVE" => "Y",
			"CODE" => $arParams["IBLOCK_ID"],
			"SITE_ID" => SITE_ID,
		));
	}
	if($arResult = $rsIBlock->GetNext())
	{
		$dbRes = CIBlockSection::GetTreeList(array("IBLOCK_ID" => $arResult['ID']));
		while ($arRes = $dbRes->Fetch()) {
			$arRes['USERS'] = array();
			$arResult["DEPARTMENTS"][$arRes["ID"]] = $arRes;
		}

		$cUser = new CUser; 
		$sort_by = "LAST_NAME";
		$sort_ord = "ASC";
		$arFilter = array(
		   "ACTIVE" => "Y",
		);
		$dbUsers = $cUser->GetList($sort_by, $sort_ord, $arFilter, array("SELECT" => array("UF_*")));
		while ($arUser = $dbUsers->Fetch()) {
			if ($arUser["UF_STRUCTURE"] > 0) {
				if (is_array($arResult["DEPARTMENTS"][$arUser["UF_STRUCTURE"]])) {
					$arResult["DEPARTMENTS"][$arUser["UF_STRUCTURE"]]["USERS"][] = $arUser;
				}
			}
		}
		
		$this->SetResultCacheKeys(array(
			"DEPARTMENTS",
		));
		$this->IncludeComponentTemplate();
	}
	else
	{
		$this->AbortResultCache();
		ShowError(GetMessage("T_NEWS_NEWS_NA"));
		@define("ERROR_404", "Y");
		if($arParams["SET_STATUS_404"]==="Y")
			CHTTP::SetStatus("404 Not Found");
	}
}
?>