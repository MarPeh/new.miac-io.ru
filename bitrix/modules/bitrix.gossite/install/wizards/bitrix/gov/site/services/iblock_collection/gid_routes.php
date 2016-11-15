<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock"))
	return;

$dir = __DIR__.'/lang/'.LANGUAGE_ID.'/';
if (file_exists($dir.'_iblockDataSelect.php')) {
	require ('lang/'.LANGUAGE_ID.'/_iblockDataSelect.php');
} else {
	require ('lang/'.LANGUAGE_ID.'/_iblockdataselect.php');
}

if (!in_array($suffix, array('mo','gd','po','zso')))
	return;

$iblockCode = "GID_routes_".WIZARD_SITE_ID;
$iblockType = "information"; 
$iblockID = false;
$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
	$iblockID = $arIBlock["ID"];

if ($iblockID)
{
	return;
}

$iblockXMLFile=WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/gid_routes/gid_routes.xml";

$iblockID = WizardServices::ImportIBlockFromXML(
	$iblockXMLFile, 
	"gossite_GID_routes",
	$iblockType, 
	WIZARD_SITE_ID, 
	$permissions = Array(
		"1" => "X",
		"2" => "R",
		WIZARD_PORTAL_ADMINISTRATION_GROUP => "X",
	)
);

if ($iblockID < 1)
	return;

//IBlock fields
$iblock = new CIBlock;
$arFields = Array(
    "ACTIVE" => "Y",
    "CODE" => $iblockCode,
	"LIST_PAGE_URL" => $path."/turizm/routes.php",
	"SECTION_PAGE_URL" => $path."/turizm/routes.php",
	"DETAIL_PAGE_URL" => $path."/turizm/detail_routes.php?ID=#ELEMENT_ID#",
    "XML_ID" => $iblockCode,
    // "NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME"),
);
$iblock->Update($iblockID, $arFields);

$arProperties = Array("ADDRESS","LAT","LNG",);
$arrPropID=array();
foreach ($arProperties as $propertyName)
{
	$arrPropID[$propertyName] = 0;
	$properties = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID, "CODE" => $propertyName));
	if ($arProperty = $properties->Fetch()) {
		$arrPropID[$propertyName] = $arProperty["ID"];
	}
}
COption::SetOptionString("bitrix.gossite", "routes_address", $arrPropID["ADDRESS"], WIZARD_SITE_ID, WIZARD_SITE_ID);
COption::SetOptionString("bitrix.gossite", "routes_lat", $arrPropID["LAT"], WIZARD_SITE_ID, WIZARD_SITE_ID);
COption::SetOptionString("bitrix.gossite", "routes_lng", $arrPropID["LNG"], WIZARD_SITE_ID, WIZARD_SITE_ID);


$typesIBlockID = COption::GetOptionString("bitrix.gossite", "routes_types_ib", $iblockID, WIZARD_SITE_ID);

$arProperty = array(
	'ENTITY_ID' => 'IBLOCK_'.$iblockID.'_SECTION',
	'FIELD_NAME' => 'UF_ROUTE_TYPE',
);



$dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => $arProperty["ENTITY_ID"], "FIELD_NAME" => $arProperty["FIELD_NAME"]));
if ($arProp = $dbRes->Fetch()) {
	$propID = $arProp['ID'];
	$arProp["EDIT_FORM_LABEL"] = array('ru' => GetMessage('ib_route_types'), 'en' => 'Route types');
	$arProp["LIST_COLUMN_LABEL"] = array('ru' => GetMessage('ib_route_types'), 'en' => 'Route types');
	$arProp["LIST_FILTER_LABEL"] = array('ru' => GetMessage('ib_route_types'), 'en' => 'Route types');
	unset ($arProp['ID']);
	$userType = new CUserTypeEntity();
	$success = (bool)$userType->Update($propID, $arProp);
}


$dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => $arProperty["ENTITY_ID"], "FIELD_NAME" => 'UF_ROUTE_TYPE_MAP'));
if ($arProp = $dbRes->Fetch()) {
	$propID = $arProp['ID'];
	$arProp["EDIT_FORM_LABEL"] = array('ru' => GetMessage('MMAP_UF_ROUTE_TYPE_text'), 'en' => 'Route type');
	$arProp["LIST_COLUMN_LABEL"] = array('ru' => GetMessage('MMAP_UF_ROUTE_TYPE_text'), 'en' => 'Route type');
	$arProp["LIST_FILTER_LABEL"] = array('ru' => GetMessage('MMAP_UF_ROUTE_TYPE_text'), 'en' => 'Route type');
	unset ($arProp['ID']);
	$userType = new CUserTypeEntity();
	$success = (bool)$userType->Update($propID, $arProp);
}
if ($propID>0) {
	$obEnum = new CUserFieldEnum;
	$LIST = array(
		'n0' => array(
			'XML_ID' => '0',
			'VALUE' => GetMessage('MMAP_UF_ROUTE_TYPE_1'),
			'SORT' => '10',
			'DEF' => 'Y',
		),
		'n1' => array(
			'XML_ID' => '30',
			'VALUE' => GetMessage('MMAP_UF_ROUTE_TYPE_2'),
			'SORT' => '20',
			'DEF' => 'N',
		),
		'n2' => array(
			'XML_ID' => '60',
			'VALUE' => GetMessage('MMAP_UF_ROUTE_TYPE_3'),
			'SORT' => '30',
			'DEF' => 'N',
		),
	);
	$success = $obEnum->SetEnumValues($propID, $LIST);
	if ($success) {
		$arTypes = array();
		$rsTypes = CUserFieldEnum::GetList(array(),array('USER_FIELD_ID'=>$propID));
		while ($arType = $rsTypes->GetNext())
			$arTypes[$arType['XML_ID']] = $arType['ID'];
		$rsSection = CIBlockSection::GetList(array(),array('IBLOCK_ID'=>$iblockID),false,array('ID','NAME','CODE','SORT','UF_*'));
		while ($arSection = $rsSection->GetNext()) {
			$arFields = array(
				'NAME' => $arSection['NAME'],
				'CODE' => $arSection['CODE'],
				'SORT' => $arSection['SORT'],
				'UF_CLOSED' => $arSection['UF_CLOSED'],
				'UF_ROUTE_TYPE' => $arSection['UF_ROUTE_TYPE'],
				'UF_ROUTE_TYPE_MAP' => $arTypes[$arSection['CODE']],
			);
			$sec = new CIBlockSection();
			$sec->Update($arSection['ID'],$arFields);
		}
	}
}

$arProperty = array(
	'ENTITY_ID' => 'IBLOCK_'.$iblockID.'_SECTION',
	'FIELD_NAME' => 'UF_CLOSED',
);


$dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => $arProperty["ENTITY_ID"], "FIELD_NAME" => $arProperty["FIELD_NAME"]));
if ($arProp = $dbRes->Fetch()) {
	$propID = $arProp['ID'];
	$arProp["EDIT_FORM_LABEL"] = array('ru' => GetMessage('ib_route_closed'), 'en' => 'Closed route');
	$arProp["LIST_COLUMN_LABEL"] = array('ru' => GetMessage('ib_route_closed'), 'en' => 'Closed route');
	$arProp["LIST_FILTER_LABEL"] = array('ru' => GetMessage('ib_route_closed'), 'en' => 'Closed route');
	unset ($arProp['ID']);
	$userType = new CUserTypeEntity();
	$success = (bool)$userType->Update($propID, $arProp);
}


WizardServices::SetUserOption('form', 'form_section_'.$iblockID, Array ( 'tabs' => 'edit1--#--'.GetMessage('iblock_GID_routes_edit1_sect').'--,--'.GetMessage('iblock_GID_routes_ID_sect').'--#--'.GetMessage('iblock_GID_routes_ID_sect').'--,--DATE_CREATE--#--'.GetMessage('iblock_GID_routes_DATE_CREATE_sect').'--,--TIMESTAMP_X--#--'.GetMessage('iblock_GID_routes_TIMESTAMP_X_sect').'--,--ACTIVE--#--'.GetMessage('iblock_GID_routes_ACTIVE_sect').'--,--NAME--#--*'.GetMessage('iblock_GID_routes_NAME_sect').'--,--UF_ROUTE_TYPE--#--*'.GetMessage('iblock_GID_routes_UF_ROUTE_TYPE_sect').'--,--UF_ROUTE_TYPE--#--*'.GetMessage('MMAP_UF_ROUTE_TYPE_text').'--,--UF_CLOSED--#--'.GetMessage('iblock_GID_routes_UF_CLOSED_sect').'--,--SORT--#--'.GetMessage('iblock_GID_routes_SORT_sect').'--,--PICTURE--#--'.GetMessage('iblock_GID_routes_PICTURE_sect').'--,--DESCRIPTION--#--'.GetMessage('iblock_GID_routes_DESCRIPTION_sect').'--;--', ), true, false);
	
WizardServices::SetIBlockFormSettings($iblockID, Array ( 'tabs' => 'edit1--#--'.GetMessage('iblock_GID_routes_edit1').'--,--ACTIVE--#--'.GetMessage('iblock_GID_routes_ACTIVE').'--,--NAME--#--*'.GetMessage('iblock_GID_routes_NAME').'--,--SECTIONS--#--'.GetMessage('iblock_GID_routes_SECTIONS').'--,--PROPERTY_'.$arrPropID['ADDRESS'].'--#--'.GetMessage('iblock_GID_routes_ADDRESS').'--,--SORT--#--'.GetMessage('iblock_GID_routes_SORT').'--,--IBLOCK_ELEMENT_PROP_VALUE--#----'.GetMessage('iblock_GID_COOORD_VALUE').'--,--PROPERTY_'.$arrPropID['LAT'].'--#--'.GetMessage('iblock_GID_routes_LAT').'--,--PROPERTY_'.$arrPropID['LNG'].'--#--'.GetMessage('iblock_GID_routes_LNG').'--;--edit5--#--'.GetMessage('iblock_GID_routes_edit5').'--,--PREVIEW_PICTURE--#--'.GetMessage('iblock_GID_routes_PREVIEW_PICTURE').'--,--PREVIEW_TEXT--#--'.GetMessage('iblock_GID_routes_PREVIEW_TEXT').'--;--', ));


$arTypes = array();
$rsEl = CIBlockElement::GetList(array(),array('IBLOCK_ID' => $typesIBlockID),false,false,array('ID','XML_ID'));
while ($arEl = $rsEl->GetNext()) {
	$arTypes[$arEl['XML_ID']] = $arEl['ID'];
}
$rsSec = CIBlockSection::GetList(array(),array('IBLOCK_ID' => $iblockID),false,array('ID','UF_ROUTE_TYPE'));
while ($arSec = $rsSec->GetNext()) {
	$sec = new CIBlockSection;
	$secID = $arSec['ID'];
	unset($arSec['ID']);
	$arSec['UF_ROUTE_TYPE'] = array($arTypes[$arSec['UF_ROUTE_TYPE'][0]]);
	$sec->Update($secID,$arSec);
}
COption::SetOptionString("bitrix.gossite", "routes_ib", $iblockID, WIZARD_SITE_ID, WIZARD_SITE_ID);

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/routes.php", array("GID_ROUTES_IBLOCK" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/detail_routes.php", array("GID_ROUTES_IBLOCK" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$path."/turizm/detail_routes.php", array("GID_BACK_URL" => WIZARD_SITE_DIR.ltrim($path,"/")));
?>
