<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arTypesEx = CIBlockParameters::GetIBlockTypes(Array("-"=>" "));

$arIBlocks=Array();
$db_iblock = CIBlock::GetList(Array("SORT"=>"ASC"), Array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];

$arSorts = Array("ASC"=>GetMessage("T_IBLOCK_DESC_ASC"), "DESC"=>GetMessage("T_IBLOCK_DESC_DESC"));
$arSortFields = Array(
		"ID"=>GetMessage("T_IBLOCK_DESC_FID"),
		"NAME"=>GetMessage("T_IBLOCK_DESC_FNAME"),
		"ACTIVE_FROM"=>GetMessage("T_IBLOCK_DESC_FACT"),
		"SORT"=>GetMessage("T_IBLOCK_DESC_FSORT"),
		"TIMESTAMP_X"=>GetMessage("T_IBLOCK_DESC_FTSAMP")
	);

$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>(isset($arCurrentValues["IBLOCK_ID"])?$arCurrentValues["IBLOCK_ID"]:$arCurrentValues["ID"])));
while ($arr=$rsProp->Fetch())
{
	$arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S")))
	{
		$arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
	}
}

$arUserFieldNames = array('ID','LOGIN','NAME','SECOND_NAME','LAST_NAME','EMAIL','DATE_REGISTER','PERSONAL_PROFESSION','PERSONAL_WWW','PERSONAL_BIRTHDAY','PERSONAL_ICQ','PERSONAL_GENDER','PERSONAL_PHOTO','PERSONAL_PHONE','PERSONAL_FAX','PERSONAL_MOBILE','PERSONAL_PAGER','PERSONAL_STREET','PERSONAL_MAILBOX','PERSONAL_CITY','PERSONAL_STATE','PERSONAL_ZIP','PERSONAL_COUNTRY','PERSONAL_NOTES','ADMIN_NOTES','WORK_POSITION', 'WORK_PHONE', 'XML_ID');

$userProp = array();

foreach ($arUserFieldNames as $name)
{
	$userProp[$name] = GetMessage('ISL_'.$name);
}

$arRes = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("USER", 0, LANGUAGE_ID);
if (!empty($arRes))
{
	foreach ($arRes as $key => $val)
	{
		$userProp[$val["FIELD_NAME"]] = (strLen($val["EDIT_FORM_LABEL"]) > 0 ? $val["EDIT_FORM_LABEL"] : $val["FIELD_NAME"]);
	}
}

$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"AJAX_MODE" => array(),
		"IBLOCK_TYPE" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_IBLOCK_DESC_LIST_TYPE"),
			"TYPE" => "LIST",
			"VALUES" => $arTypesEx,
			"DEFAULT" => "news",
			"REFRESH" => "Y",
		),
		
		"STRUCTURE_IBLOCK_ID" => Array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("T_STRUCTURE_IBLOCK_ID"),
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '={$_REQUEST["ID"]}',
			"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),			
		'EC_URL' => array(
				'TYPE' => 'STRING',
				'DEFAULT' => '#SITE_DIR#rukovodstvo/user/#USER_ID#/',
				'NAME' => GetMessage('INTR_ISL_TPL_PARAM_EC_URL'),
		),
			
		"USER_PROPERTY"=>array(
			"NAME" => GetMessage('INTR_ISL_TPL_PARAM_USER_PROPERTY'),
			"TYPE" => "LIST",
			"VALUES" => $userProp,
			"MULTIPLE" => "Y",
			"DEFAULT" => array('ID', 'LOGIN', 'FULL_NAME'),
		),
		
	),
);
//CIBlockParameters::AddPagerSettings($arComponentParameters, GetMessage("T_IBLOCK_DESC_PAGER_NEWS"), true, true);
?>
