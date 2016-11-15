<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (WIZARD_IS_RERUN)
	return;

if(!CModule::IncludeModule("statistic"))
	return;

$APPLICATION->SetGroupRight("statistic", WIZARD_PORTAL_ADMINISTRATION_GROUP, "W");


$arFields = array(
		"EVENT1"		=>  '"download"',
		"EVENT2"		=> '"update"',
		"ADV_VISIBLE"		=> '"Y"',
		"NAME"			=>  '"'.GetMessage('EVENT_DOWNLOAD_NAME').'"',
		"DESCRIPTION"		=> "",
		"KEEP_DAYS"		=> "",
		"C_SORT"		=> "100",
		"DIAGRAM_DEFAULT"	=> '"Y"',
		"DYNAMIC_KEEP_DAYS"	=> ""
		);
		
$arFields["DATE_ENTER"] = "null";
$arFields["DATE_CLEANUP"] = "null";
$ID = $DB->Insert("b_stat_event",$arFields, $err_mess.__LINE__);
?>