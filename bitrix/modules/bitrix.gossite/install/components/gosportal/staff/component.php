<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

$included = CModule::IncludeModuleEx('bitrix.gossite');
if ($included==MODULE_NOT_FOUND) {
	ShowError(GetMessage('SCHOOLWEBSITE_MODULE_NOT_INSTALLED'));
	return;
}
if ($included==MODULE_DEMO_EXPIRED) {
	ShowError(GetMessage('SCHOOLWEBSITE_MODULE_DEMO_EXPIRED'));
	return;
}


if($arParams["USE_FILTER"]=="Y")
{
	if(strlen($arParams["FILTER_NAME"])<=0 || !preg_match("/^[A-Za-z_][A-Za-z01-9_]*$/", $arParams["FILTER_NAME"]))
		$arParams["FILTER_NAME"] = "arrFilter";
}
else
	$arParams["FILTER_NAME"] = "";

$arParams["USE_CATEGORIES"]=$arParams["USE_CATEGORIES"]=="Y";
if($arParams["USE_CATEGORIES"])
{
	if(!is_array($arParams["CATEGORY_IBLOCK"]))
		$arParams["CATEGORY_IBLOCK"] = array();
	$ar = array();
	foreach($arParams["CATEGORY_IBLOCK"] as $key=>$value)
	{
		$value=intval($value);
		if($value>0)
			$ar[$value]=true;
	}
	$arParams["CATEGORY_IBLOCK"] = array_keys($ar);
}
$arParams["CATEGORY_CODE"]=trim($arParams["CATEGORY_CODE"]);
if(strlen($arParams["CATEGORY_CODE"])<=0)
	$arParams["CATEGORY_CODE"]="CATEGORY";
$arParams["CATEGORY_ITEMS_COUNT"]=intval($arParams["CATEGORY_ITEMS_COUNT"]);
if($arParams["CATEGORY_ITEMS_COUNT"]<=0)
	$arParams["CATEGORY_ITEMS_COUNT"]=5;

if(!is_array($arParams["CATEGORY_IBLOCK"]))
	$arParams["CATEGORY_IBLOCK"] = array();
foreach($arParams["CATEGORY_IBLOCK"] as $iblock_id)
	if($arParams["CATEGORY_THEME_".$iblock_id]!="photo")
		$arParams["CATEGORY_THEME_".$iblock_id]="list";

$arDefaultUrlTemplates404 = array(
	"news" => "",
	"search" => "search/",
	"detail" => "#ELEMENT_ID#/",
	"section" => "",
);

$arDefaultVariableAliases404 = array();

$arDefaultVariableAliases = array();

$arComponentVariables = array(
	"SECTION_ID",
	"SECTION_CODE",
	"ELEMENT_ID",
	"ELEMENT_CODE",
);

if($arParams["USE_SEARCH"] != "Y")
{
	unset($arDefaultUrlTemplates404["search"]);
	unset($arParams["SEF_URL_TEMPLATES"]["search"]);
}
else
{
	$arComponentVariables[] = "q";
	$arComponentVariables[] = "tags";
}

	unset($arDefaultUrlTemplates404["rss"]);
	unset($arDefaultUrlTemplates404["rss_section"]);
	unset($arParams["SEF_URL_TEMPLATES"]["rss"]);
	unset($arParams["SEF_URL_TEMPLATES"]["rss_section"]);


if($arParams["SEF_MODE"] == "Y")
{
	$arVariables = array();

	$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates($arDefaultUrlTemplates404, $arParams["SEF_URL_TEMPLATES"]);
	$arVariableAliases = CComponentEngine::MakeComponentVariableAliases($arDefaultVariableAliases404, $arParams["VARIABLE_ALIASES"]);

	$engine = new CComponentEngine($this);
	if (CModule::IncludeModule('iblock'))
	{
		$engine->addGreedyPart("#SECTION_CODE_PATH#");
		$engine->setResolveCallback(array("CIBlockFindTools", "resolveComponentEngine"));
	}
	$componentPage = $engine->guessComponentPath(
		$arParams["SEF_FOLDER"],
		$arUrlTemplates,
		$arVariables
	);
	$b404 = false;
	if(!$componentPage)
	{
		$componentPage = "news";
		$b404 = true;
	}

	if(
		$componentPage == "section"
		&& isset($arVariables["SECTION_ID"])
		&& intval($arVariables["SECTION_ID"])."" !== $arVariables["SECTION_ID"]
	)
		$b404 = true;

	if($b404 && $arParams["SET_STATUS_404"]==="Y")
	{
		$folder404 = str_replace("\\", "/", $arParams["SEF_FOLDER"]);
		if ($folder404 != "/")
			$folder404 = "/".trim($folder404, "/ \t\n\r\0\x0B")."/";
		if (substr($folder404, -1) == "/")
			$folder404 .= "index.php";

			if($folder404 != $APPLICATION->GetCurPage(true))
			CHTTP::SetStatus("404 Not Found");
	}

	CComponentEngine::InitComponentVariables($componentPage, $arComponentVariables, $arVariableAliases, $arVariables);

	$arResult = array(
		"FOLDER" => $arParams["SEF_FOLDER"],
		"URL_TEMPLATES" => $arUrlTemplates,
		"VARIABLES" => $arVariables,
		"ALIASES" => $arVariableAliases,
	);
}
else
{
	$arVariableAliases['ELEMENT_ID'] = 'USER';
	CComponentEngine::InitComponentVariables(false, $arComponentVariables, $arVariableAliases, $arVariables);
	$componentPage = "";

	if(isset($arVariables["ELEMENT_ID"]) && intval($arVariables["ELEMENT_ID"]) > 0)
		$componentPage = "detail";
	elseif(isset($arVariables["ELEMENT_CODE"]) && strlen($arVariables["ELEMENT_CODE"]) > 0)
		$componentPage = "detail";
	else
		$componentPage = "news";
	$arResult = array(
		"FOLDER" => "",
		"URL_TEMPLATES" => Array(
			"news" => htmlspecialcharsbx($APPLICATION->GetCurPage()),
			"detail" => htmlspecialcharsbx($APPLICATION->GetCurPage()."?USER=#ELEMENT_ID#"),
		),
		"VARIABLES" => $arVariables,
		"ALIASES" => $arVariableAliases
	);
}

if($componentPage=="search")
{
	include_once("newstools.php");
	global $BX_NEWS_DETAIL_URL, $BX_NEWS_SECTION_URL;
	$BX_NEWS_DETAIL_URL = $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"];
	$BX_NEWS_SECTION_URL = $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"];
	AddEventHandler("search", "OnSearchGetURL", array("CNewsTools","OnSearchGetURL"), 20);
}
$this->IncludeComponentTemplate($componentPage);

?>