<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock"))
	return;

$wizard =& $this->GetWizard();
$suffix = substr($wizard->GetVar("typeID"), 5);

$arTypes = Array(

	Array(
		"ID" => "news",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 5,
		"LANG" => Array(),
	),

	Array(
		"ID" => "administration",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 10,
		"LANG" => Array(),
	),
	Array(
		"ID" => "authorities",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 15,
		"LANG" => Array(),
	),

	Array(
		"ID" => "benefits",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 20,
		"LANG" => Array(),
	),

	Array(
		"ID" => "documents",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 30,
		"LANG" => Array(),
	),

	Array(
		"ID" => "feedback",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 40,
		"LANG" => Array(),
	),

	Array(
		"ID" => "gosserv",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 50,
		"LANG" => Array(),
	),

	Array(
		"ID" => "massmedia",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 60,
		"LANG" => Array(),
	),

	Array(
		"ID" => "orders",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 80,
		"LANG" => Array(),
	),

	Array(
		"ID" => "photovideogallery",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 90,
		"LANG" => Array(),
	),

	Array(
		"ID" => "results",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 100,
		"LANG" => Array(),
	),

	Array(
		"ID" => "vacancies",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 110,
		"LANG" => Array(),
	),

	Array(
		"ID" => "visits",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 130,
		"LANG" => Array(),
	),

	Array(
		"ID" => "structure",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 140,
		"LANG" => Array(),
	),
	
	Array(
		"ID" => "information",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 160,
		"LANG" => Array(),
	),
	Array(
		"ID" => "normative",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 170,
		"LANG" => Array(),
	),
	Array(
		"ID" => "guide_map",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 180,
		"LANG" => Array(),
	),

);

if($suffix=="prokuratura")
{
	$arTypes[]=Array(
				"ID" => "mypolice",
				"SECTIONS" => "Y",
				"IN_RSS" => "N",
				"SORT" => 150,
				"LANG" => Array(),
			);
}

if($suffix=="zags")
{
	$arTypes[]=Array(
		"ID" => "contacts",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 150,
		"LANG" => Array(),
	);
	$arTypes[]=Array(
		"ID" => "department2",
		"SECTIONS" => "Y",
		"IN_RSS" => "N",
		"SORT" => 160,
		"LANG" => Array(),
	);
}

$languageID = 'ru';

$iblockType = new CIBlockType;
foreach($arTypes as $arType)
{
	echo $arType["ID"].",";
	$dbType = CIBlockType::GetList(Array(),Array("=ID" => $arType["ID"]));
	if($dbType->Fetch())
		continue;

		WizardServices::IncludeServiceLang('type_names_'.$suffix.'.php', $languageID);

		$code = strtoupper($arType["ID"]);
		$arType["LANG"][$languageID]["NAME"] = GetMessage($code."_TYPE_NAME");
		$arType["LANG"][$languageID]["ELEMENT_NAME"] = GetMessage($code."_ELEMENT_NAME");

		if ($arType["SECTIONS"] == "Y")
			$arType["LANG"][$languageID]["SECTION_NAME"] = GetMessage($code."_SECTION_NAME");

	$iblockType->Add($arType);
}

COption::SetOptionString("bitrix.gossite", "info_ib_type", 'guide_map', WIZARD_SITE_ID, WIZARD_SITE_ID);

?>