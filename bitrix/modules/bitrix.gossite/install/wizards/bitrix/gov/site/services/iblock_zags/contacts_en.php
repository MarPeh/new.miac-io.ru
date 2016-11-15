<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if(!CModule::IncludeModule("iblock"))
	return;
$iblockCode = "contacts_en_".WIZARD_SITE_ID;
$iblockType = "structure";
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."english/contacts.php", array("CONTACTS_IBLOCK_ID" => $iblockID));
    return;
}

$iblockID = WizardServices::ImportIBlockFromXML(
	WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID."/contacts_en.xml", 
	"gossite_contacts_en",
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
$iblock = new CIBlock;
$arFields = Array(
    "ACTIVE" => "Y",
    "CODE" => $iblockCode,
    "XML_ID" => $iblockCode,
    // "NAME" => "[".WIZARD_SITE_ID."] ".$iblock->GetArrayByID($iblockID, "NAME"),
);
$iblock->Update($iblockID, $arFields);

$arProperties = Array("POST", "FIO", "ADDRESS", "PHONE");
foreach ($arProperties as $propertyName)
{
	${$propertyName."_PROPERTY_ID"} = 0;
	$properties = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID, "CODE" => $propertyName));
	if ($arProperty = $properties->Fetch())
		${$propertyName."_PROPERTY_ID"} = $arProperty["ID"];
}

WizardServices::SetIBlockFormSettings($iblockID, Array ( 'tabs' => GetMessage("W_IB_CONTACTS_TABS1", array(
	"PROPERTY_POST" => "PROPERTY_".$POST_PROPERTY_ID,
	"PROPERTY_FIO" => "PROPERTY_".$FIO_PROPERTY_ID,
	"PROPERTY_ADDRESS" => "PROPERTY_".$ADDRESS_PROPERTY_ID,
	"PROPERTY_PHONE" => "PROPERTY_".$PHONE_PROPERTY_ID,
))));

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH."english/contacts.php", array("CONTACTS_IBLOCK_ID" => $iblockID));
?>