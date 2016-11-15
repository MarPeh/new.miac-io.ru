<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var array $arCurrentValues */

if(!CModule::IncludeModule("iblock"))
    return;

global $USER_FIELD_MANAGER;

$arTypesEx = CIBlockParameters::GetIBlockTypes(Array("-"=>" "));

$arIBlocks=Array();
$db_iblock = CIBlock::GetList(Array("SORT"=>"ASC"), Array("SITE_ID"=>$_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")));
while($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = $arRes["NAME"];

$arSorts = Array("ASC"=>GetMessage("T_MAP_DESC_ASC"), "DESC"=>GetMessage("T_MAP_DESC_DESC"));
$arSortFields = Array(
    "ID"=>GetMessage("T_MAP_DESC_FID"),
    "NAME"=>GetMessage("T_MAP_DESC_FNAME"),
    "ACTIVE_FROM"=>GetMessage("T_MAP_DESC_FACT"),
    "SORT"=>GetMessage("T_MAP_DESC_FSORT"),
    "TIMESTAMP_X"=>GetMessage("T_MAP_DESC_FTSAMP")
);
$arSortSectionFields = Array(
    "ID"=>GetMessage("T_MAP_DESC_FID"),
    "NAME"=>GetMessage("T_MAP_DESC_FNAME"),
    "SORT"=>GetMessage("T_MAP_DESC_FSORT"),
    "TIMESTAMP_X"=>GetMessage("T_MAP_DESC_FTSAMP")
);

$arProperty_LNS = array();
$arProperty_Files = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>(isset($arCurrentValues["IBLOCK_ID"])?$arCurrentValues["IBLOCK_ID"]:$arCurrentValues["ID"])));
while ($arr=$rsProp->Fetch())
{
    $arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "E")))
    {
        $arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    }
    elseif (in_array($arr["PROPERTY_TYPE"], array("F")))
    {
        $arProperty_Files[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    }
}
$arProperty_LNS_Null = array_merge(array("" => GetMessage("T_MAP_DESC_NO_PROP")), $arProperty_LNS);

$arProperty_UF = array();
$arUserFields = $USER_FIELD_MANAGER->GetUserFields("IBLOCK_".$arCurrentValues["IBLOCK_ID"]."_SECTION");
foreach($arUserFields as $FIELD_NAME=>$arUserField)
{
    $arProperty_UF[$FIELD_NAME] = $arUserField["LIST_COLUMN_LABEL"]? $arUserField["LIST_COLUMN_LABEL"]: $FIELD_NAME;
}

$arComponentParameters = array(
    "GROUPS" => array(
        "MAP_SETTINGS" => array(
            "NAME" => GetMessage("T_MAP_SECTION_MAP_SETTINGS"),
            "SORT" => 1000
        ),
        "MAP_EL_PROPERTIES" => array(
            "NAME" => GetMessage("T_MAP_SECTION_MAP_EL_PROPERTIES"),
            "SORT" => 1100
        ),
    ),
    "PARAMETERS" => array(
        "IBLOCK_TYPE" => Array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_MAP_DESC_LIST_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "DEFAULT" => "map",
            "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => Array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_MAP_DESC_LIST_ID"),
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "DEFAULT" => '={$_REQUEST["ID"]}',
            "ADDITIONAL_VALUES" => "Y",
            "REFRESH" => "Y",
        ),
        "DATA_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_MAP_DESC_DATA_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => array(
                "objects" => GetMessage("T_MAP_DESC_DATA_TYPE_OBJECTS"),
                "events" => GetMessage("T_MAP_DESC_DATA_TYPE_EVENTS"),
                "routes" => GetMessage("T_MAP_DESC_DATA_TYPE_ROUTES"),
            ),
            "DEFAULT" => "objects",
            "REFRESH" => "Y"
        ),
        "ELEMENTS_COUNT" => Array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_MAP_DESC_LIST_CONT"),
            "TYPE" => "STRING",
            "DEFAULT" => "500",
        ),
        "SHOW_ELEMENTS_COUNT" => Array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("T_MAP_DESC_SHOW_ELEMENTS_COUNT"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
        "SORT_SECTIONS_BY1" => Array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_MAP_DESC_SECTIONS_IBORD1"),
            "TYPE" => "LIST",
            "DEFAULT" => "NAME",
            "VALUES" => $arSortSectionFields,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "SORT_SECTIONS_ORDER1" => Array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_MAP_DESC_SECTIONS_IBBY1"),
            "TYPE" => "LIST",
            "DEFAULT" => "DESC",
            "VALUES" => $arSorts,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "SORT_SECTIONS_BY2" => Array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_MAP_DESC_SECTIONS_IBORD2"),
            "TYPE" => "LIST",
            "DEFAULT" => "SORT",
            "VALUES" => $arSortSectionFields,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "SORT_SECTIONS_ORDER2" => Array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_MAP_DESC_SECTIONS_IBBY2"),
            "TYPE" => "LIST",
            "DEFAULT" => "ASC",
            "VALUES" => $arSorts,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "SORT_BY1" => Array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_MAP_DESC_IBORD1"),
            "TYPE" => "LIST",
            "DEFAULT" => "SORT",
            "VALUES" => $arSortFields,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "SORT_ORDER1" => Array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_MAP_DESC_IBBY1"),
            "TYPE" => "LIST",
            "DEFAULT" => "DESC",
            "VALUES" => $arSorts,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "SORT_BY2" => Array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_MAP_DESC_IBORD2"),
            "TYPE" => "LIST",
            "DEFAULT" => "NAME",
            "VALUES" => $arSortFields,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "SORT_ORDER2" => Array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_MAP_DESC_IBBY2"),
            "TYPE" => "LIST",
            "DEFAULT" => "ASC",
            "VALUES" => $arSorts,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "FILTER_NAME" => Array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_MAP_FILTER"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "SECTION_FIELDS" => CIBlockParameters::GetSectionFieldCode(
                                             GetMessage("CP_BCSL_SECTION_FIELDS"),
                                                 "DATA_SOURCE",
                                                 array()
            ),
        "FIELD_CODE" => CIBlockParameters::GetFieldCode(GetMessage("MAP_FIELD"), "DATA_SOURCE"),
        "PROPERTY_CODE" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_MAP_PROPERTY"),
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "VALUES" => $arProperty_LNS,
            "ADDITIONAL_VALUES" => "Y",
        ),
        "CHECK_DATES" => array(
            "PARENT" => "DATA_SOURCE",
            "NAME" => GetMessage("T_MAP_DESC_CHECK_DATES"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
        "DETAIL_URL" => CIBlockParameters::GetPathTemplateParam(
                                         "DETAIL",
                                             "DETAIL_URL",
                                             GetMessage("T_MAP_DESC_DETAIL_PAGE_URL"),
                                             "",
                                             "URL_TEMPLATES"
            ),
        "PREVIEW_TRUNCATE_LEN" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("T_MAP_DESC_PREVIEW_TRUNCATE_LEN"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "ACTIVE_DATE_FORMAT" => CIBlockParameters::GetDateFormat(GetMessage("T_MAP_DESC_ACTIVE_DATE_FORMAT"), "ADDITIONAL_SETTINGS"),
        "SET_TITLE" => Array(),
        "SET_STATUS_404" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("CP_BNL_SET_STATUS_404"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
        "INCLUDE_IBLOCK_INTO_CHAIN" => Array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("T_MAP_DESC_INCLUDE_IBLOCK_INTO_CHAIN"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
        "PARENT_SECTION" => array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("MAP_SECTION_ID"),
            "TYPE" => "STRING",
            "DEFAULT" => '',
        ),
        "PARENT_SECTION_CODE" => array(
            "PARENT" => "ADDITIONAL_SETTINGS",
            "NAME" => GetMessage("MAP_SECTION_CODE"),
            "TYPE" => "STRING",
            "DEFAULT" => '',
        ),
        "CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
        "CACHE_FILTER" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("MAP_CACHE_FILTER"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
        "CACHE_GROUPS" => array(
            "PARENT" => "CACHE_SETTINGS",
            "NAME" => GetMessage("CP_BNL_CACHE_GROUPS"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "Y",
        ),
    ),
);

if (CModule::IncludeModule("bitrix.map")) {
	$arComponentParameters["PARAMETERS"] = array_merge($arComponentParameters["PARAMETERS"], array(
		"MAP_TYPE" => array(
            "PARENT" => "MAP_SETTINGS",
            "NAME" => GetMessage("T_MAP_DESC_MAP_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => array(
                "google" => GetMessage("T_MAP_DESC_MAP_TYPE_GOOLGE"),
                "yandex" => GetMessage("T_MAP_DESC_MAP_TYPE_YANDEX"),
            ),
            "DEFAULT" => "google",
        ),
        "UNIVERSAL_MARKER" => array(
            "PARENT" => "MAP_SETTINGS",
            "NAME" => GetMessage("T_MAP_DESC_UNIVERSAL_MARKER"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
        "NO_CAT_ICONS" => array(
            "PARENT" => "MAP_SETTINGS",
            "NAME" => GetMessage("T_MAP_DESC_NO_CAT_ICONS"),
            "TYPE" => "CHECKBOX",
            "DEFAULT" => "N",
        ),
	));

	if ($arCurrentValues["DATA_TYPE"] == "routes")
	{
		$arComponentParameters["PARAMETERS"]["ROUTETYPE_PROP_CODE"] = array(
			"PARENT" => "MAP_EL_PROPERTIES",
			"NAME" => GetMessage("T_MAP_DESC_ROUTETYPE_PROP_CODE"),
			"TYPE" => "LIST",
			"DEFAULT" => "",
			"VALUES" => $arProperty_UF,
			"ADDITIONAL_VALUES" => "Y",
		);
		$arComponentParameters["PARAMETERS"]["CLOSED_PROP_CODE"] = array(
			"PARENT" => "MAP_EL_PROPERTIES",
			"NAME" => GetMessage("T_MAP_DESC_CLOSED_PROP_CODE"),
			"TYPE" => "LIST",
			"DEFAULT" => "UF_CLOSED",
			"VALUES" => $arProperty_UF,
			"ADDITIONAL_VALUES" => "Y",
		);
	}
	else if ($arCurrentValues["DATA_TYPE"] == "objects")
	{
		$arComponentParameters["PARAMETERS"]["ICONPOS_PROP_CODE"] = array(
			"PARENT" => "MAP_EL_PROPERTIES",
			"NAME" => GetMessage("T_MAP_DESC_ICONPOS_PROP_CODE"),
			"TYPE" => "LIST",
			"DEFAULT" => "UF_ICON_POS",
			"VALUES" => $arProperty_UF,
			"ADDITIONAL_VALUES" => "Y",
		);
		$arComponentParameters["PARAMETERS"]["PARENT_PROP_CODE"] = array(
			"PARENT" => "MAP_EL_PROPERTIES",
			"NAME" => GetMessage("T_MAP_DESC_PARENT_PROP_CODE"),
			"TYPE" => "LIST",
			"DEFAULT" => "PARENT",
			"VALUES" => $arProperty_LNS,
			"ADDITIONAL_VALUES" => "Y",
		);
	}

	$arComponentParameters["PARAMETERS"] = array_merge($arComponentParameters["PARAMETERS"], array(

		  "NAME_PROP_CODE" => array(
			  "PARENT" => "MAP_EL_PROPERTIES",
			  "NAME" => GetMessage("T_MAP_DESC_NAME_PROP_CODE"),
			  "TYPE" => "LIST",
			  "DEFAULT" => "",
			  "VALUES" => $arProperty_LNS,
			  "ADDITIONAL_VALUES" => "Y",
		  ),
		  "LATITUDE_PROP_CODE" => array(
			  "PARENT" => "MAP_EL_PROPERTIES",
			  "NAME" => GetMessage("T_MAP_DESC_LATITUDE_PROP_CODE"),
			  "TYPE" => "LIST",
			  "DEFAULT" => "LATITUDE",
			  "VALUES" => $arProperty_LNS,
			  "ADDITIONAL_VALUES" => "Y",
		  ),
		  "LONGITUDE_PROP_CODE" => array(
			  "PARENT" => "MAP_EL_PROPERTIES",
			  "NAME" => GetMessage("T_MAP_DESC_LONGITUDE_PROP_CODE"),
			  "TYPE" => "LIST",
			  "DEFAULT" => "LONGITUDE",
			  "VALUES" => $arProperty_LNS,
			  "ADDITIONAL_VALUES" => "Y",
		  ),
		  "ADDRESS_PROP_CODE" => array(
			  "PARENT" => "MAP_EL_PROPERTIES",
			  "NAME" => GetMessage("T_MAP_DESC_ADDRESS_PROP_CODE"),
			  "TYPE" => "LIST",
			  "DEFAULT" => "",
			  "VALUES" => $arProperty_LNS_Null,
			  "ADDITIONAL_VALUES" => "Y",
		  ),
		  "PHONE_PROP_CODE" => array(
			  "PARENT" => "MAP_EL_PROPERTIES",
			  "NAME" => GetMessage("T_MAP_DESC_PHONE_PROP_CODE"),
			  "TYPE" => "LIST",
			  "DEFAULT" => "",
			  "VALUES" => $arProperty_LNS_Null,
			  "ADDITIONAL_VALUES" => "Y",
		  ),
		  "OPENING_PROP_CODE" => array(
			  "PARENT" => "MAP_EL_PROPERTIES",
			  "NAME" => GetMessage("T_MAP_DESC_OPENING_PROP_CODE"),
			  "TYPE" => "LIST",
			  "DEFAULT" => "",
			  "VALUES" => $arProperty_LNS_Null,
			  "ADDITIONAL_VALUES" => "Y",
		  ),
		  "LINK_PROP_CODE" => array(
			  "PARENT" => "MAP_EL_PROPERTIES",
			  "NAME" => GetMessage("T_MAP_DESC_LINK_PROP_CODE"),
			  "TYPE" => "LIST",
			  "DEFAULT" => "",
			  "VALUES" => $arProperty_LNS_Null,
			  "ADDITIONAL_VALUES" => "Y",
		  ),
		  "PICTURE_PROP_CODE" => array(
			  "PARENT" => "MAP_EL_PROPERTIES",
			  "NAME" => GetMessage("T_MAP_DESC_PICTURE_PROP_CODE"),
			  "TYPE" => "LIST",
			  "DEFAULT" => "",
			  "VALUES" => $arProperty_Files,
			  "ADDITIONAL_VALUES" => "Y",
		  ),
	 ));
 
}
?>
