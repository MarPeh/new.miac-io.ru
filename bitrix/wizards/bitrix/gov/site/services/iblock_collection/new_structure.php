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

$iblockCode = "new_struct_".WIZARD_SITE_ID;
$iblockType = "structure";

$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$rukovodstvo."/rukovodstvo/index.php", array("STRUCTURE_IBLOCK_ID" => $iblockID));

    return;
}

$iblockID = WizardServices::ImportIBlockFromXML(
	WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID.'/struct.xml', 
	"gossite_new_struct",
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
    "XML_ID" => $iblockCode,
    // "NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME"),
	"FIELDS" => array(
		'LOG_SECTION_ADD'=>array('IS_REQUIRED' =>'Y'),
		'LOG_SECTION_EDIT'=>array('IS_REQUIRED' =>'Y'),
		'LOG_SECTION_DELETE'=>array('IS_REQUIRED' =>'Y'),
		'LOG_ELEMENT_ADD'=>array('IS_REQUIRED' =>'Y'),
		'LOG_ELEMENT_EDIT'=>array('IS_REQUIRED' =>'Y'),
		'LOG_ELEMENT_DELETE'=>array('IS_REQUIRED' =>'Y'),
	)
);

$iblock->Update($iblockID, $arFields);
$arProperty = Array(
	'ENTITY_ID' => 'USER',
	'FIELD_NAME' => 'UF_STRUCTURE',
	'USER_TYPE_ID' => 'iblock_section',
	'XML_ID' => '',
	'SORT' => 1,
	'MULTIPLE' => 'N',
	'MANDATORY' => 'N',
	'SHOW_FILTER' => 'I',
	'SHOW_IN_LIST' => 'Y',
	'EDIT_IN_LIST' => 'Y',
	'IS_SEARCHABLE' => 'Y',
	'SETTINGS' => array(
		'DISPLAY' => 'LIST',
		'LIST_HEIGHT' => '8',
		'IBLOCK_ID' => $iblockID,
	)
);
$dbRes = CUserTypeEntity::GetList(Array(), Array("ENTITY_ID" => $arProperty["ENTITY_ID"], "FIELD_NAME" => $arProperty["FIELD_NAME"]));

if (!$dbRes->Fetch())
{
	$arProperty["EDIT_FORM_LABEL"] = array('ru'=>GetMessage('ib_dep_deps'), 'en'=>'Departments');
	$arProperty["LIST_COLUMN_LABEL"] = array('ru'=>GetMessage('ib_dep_deps'), 'en'=>'Departments');
	$arProperty["LIST_FILTER_LABEL"] = array('ru'=>GetMessage('ib_dep_deps'), 'en'=>'Departments');

	$userType = new CUserTypeEntity();
	$success = (bool)$userType->Add($arProperty);

}


CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$rukovodstvo."/rukovodstvo/index.php", array("STRUCTURE_IBLOCK_ID" => $iblockID));

?>