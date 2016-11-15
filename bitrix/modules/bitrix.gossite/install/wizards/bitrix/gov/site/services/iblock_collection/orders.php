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

$iblockCode = "orders_".WIZARD_SITE_ID;
$iblockType = "orders";
$iblockID = false;

$rsIBlock = CIBlock::GetList(array(), array("CODE" => $iblockCode, "TYPE" => $iblockType));
if ($rsIBlock && $arIBlock = $rsIBlock->Fetch())
    $iblockID = $arIBlock["ID"];

if ($iblockID)
{
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$order."/mun-order/index.php", array("ORDERS_IBLOCK_ID" => $iblockID));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$order."/mun-order/rss.php", array("ORDERS_IBLOCK_ID" => $iblockID));
    return;
}

$iblockID = WizardServices::ImportIBlockFromXML(
	WIZARD_SERVICE_RELATIVE_PATH."/xml/".LANGUAGE_ID.'/orders/orders_'.$suffix.'.xml', 
	"gossite_orders",
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
	
$arProperties = Array("CUSTOMER", "FIN_SOURCE", "COTIR", "GOODS", "COTIR_SEND", "PAYMENT", "PROJECT", "DOCS", "CONTRACT", "VIEW_STATE", "OPEN_DATE", "DOC_PAYMENT", "CONTEST_DOC", "ENDS", "MUN_CONTRACT", "AUCT_DOCS", "AUCT_DOC_PAYMENT", "AUCT_DATA", "ORGS_BENEFITS");
foreach ($arProperties as $propertyName)
{
	${$propertyName."_PROPERTY_ID"} = 0;
	$properties = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID" => $iblockID, "CODE" => $propertyName));
	if ($arProperty = $properties->Fetch())
		${$propertyName."_PROPERTY_ID"} = $arProperty["ID"];
}

WizardServices::SetIBlockFormSettings($iblockID, array('tabs'=>'cedit1--#--'.GetMessage('iblock_orders_general').
	'--,--ACTIVE_FROM--#--*'.GetMessage('iblock_orders_date1').
	'--,--ACTIVE_TO--#--'.GetMessage('iblock_orders_date2').
	'--,--NAME--#--*'.GetMessage('iblock_orders_name').
	'--,--SECTIONS--#--'.GetMessage('iblock_orders_type').'--,--PROPERTY_'.$CUSTOMER_PROPERTY_ID.
	'--#--'.GetMessage('iblock_orders_info').
	'--,--cedit1_csection1--#----'.GetMessage('iblock_orders_docs').
	'--,--PROPERTY_'.$PROJECT_PROPERTY_ID.
	'--#--'.GetMessage('iblock_orders_project').'--,--PROPERTY_'.$DOCS_PROPERTY_ID.
	'--#--'.GetMessage('iblock_orders_docs2').
	'--;--cedit2--#--'.GetMessage('iblock_orders_request').
	'--,--PROPERTY_'.$FIN_SOURCE_PROPERTY_ID.
	'--#--'.GetMessage('iblock_orders_istochnik').'--,--PROPERTY_'.$COTIR_PROPERTY_ID.
	'--#--'.GetMessage('iblock_orders_form').'--,--PROPERTY_'.$GOODS_PROPERTY_ID.
	'--#--'.GetMessage('iblock_orders_info2').'--,--PROPERTY_'.$COTIR_SEND_PROPERTY_ID.
	'--#--'.GetMessage('iblock_orders_info3').'--,--PROPERTY_'.$PAYMENT_PROPERTY_ID.
	'--#--'.GetMessage('iblock_orders_info4').
	'--;--cedit3--#--'.GetMessage('iblock_orders_open').'--,--PROPERTY_'.$CONTRACT_PROPERTY_ID.
	'--#--'.GetMessage('iblock_orders_info5').
	'--,--PROPERTY_'.$VIEW_STATE_PROPERTY_ID.'--#--'.GetMessage('iblock_orders_info6').
	'--,--PROPERTY_'.$OPEN_DATE_PROPERTY_ID.'--#--'.GetMessage('iblock_orders_info7').
	'--,--PROPERTY_'.$DOC_PAYMENT_PROPERTY_ID.'--#--'.GetMessage('iblock_orders_info8').
	'--,--PROPERTY_'.$CONTEST_DOC_PROPERTY_ID.'--#--'.GetMessage('iblock_orders_info9').
	'--,--PROPERTY_'.$ENDS_PROPERTY_ID.'--#--'.GetMessage('iblock_orders_info10').
	'--;--cedit4--#--'.GetMessage('iblock_orders_open2').
	'--,--PROPERTY_'.$MUN_CONTRACT_PROPERTY_ID.'--#--'.GetMessage('iblock_orders_info11').
	'--,--PROPERTY_'.$AUCT_DOCS_PROPERTY_ID.'--#--'.GetMessage('iblock_orders_info12').
	'--,--PROPERTY_'.$AUCT_DOC_PAYMENT_PROPERTY_ID.'--#--'.GetMessage('iblock_orders_info13').
	'--,--PROPERTY_'.$AUCT_DATA_PROPERTY_ID.'--#--'.GetMessage('iblock_orders_info14').
	'--,--PROPERTY_'.$ORGS_BENEFITS_PROPERTY_ID.'--#--'.GetMessage('iblock_orders_benefits').'--;--'));

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$order."/mun-order/index.php", array("ORDERS_IBLOCK_ID" => $iblockID));
CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.$order."/mun-order/rss.php", array("ORDERS_IBLOCK_ID" => $iblockID));
?>