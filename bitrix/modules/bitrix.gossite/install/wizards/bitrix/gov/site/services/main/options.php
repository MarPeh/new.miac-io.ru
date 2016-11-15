<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (WIZARD_IS_RERUN)
	return;

$wizard =& $this->GetWizard();
COption::SetOptionString("bitrix.gossite", "demo_type", $wizard->GetVar("typeID"), WIZARD_SITE_ID, WIZARD_SITE_ID);

COption::SetOptionString("form", "SIMPLE", "N");

COption::SetOptionString("main", "map_top_menu_type", "top");
COption::SetOptionString("main", "map_left_menu_type", "left");
?>
