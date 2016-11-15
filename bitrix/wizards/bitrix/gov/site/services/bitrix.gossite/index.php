<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

//if (WIZARD_IS_RERUN)
//	return;

if(!CModule::IncludeModule("bitrix.gossite"))
	return;

if (file_exists($_SERVER["DOCUMENT_ROOT"].'/bitrix/templates/mobile/themes/'.WIZARD_THEME_ID))
	CopyDirFiles(
		$_SERVER["DOCUMENT_ROOT"].'/bitrix/templates/mobile/themes/'.WIZARD_THEME_ID,
		$_SERVER["DOCUMENT_ROOT"].'/bitrix/templates/mobile/',
		$rewrite = true,
		$recursive = true,
		$delete_after_copy = false,
		$exclude = "description.php"
	);


$wizard =& $this->GetWizard();
//COption::SetOptionString("bitrix.gossite", "map_city",  $wizard->GetVar("siteCity"), WIZARD_SITE_ID, WIZARD_SITE_ID);
COption::SetOptionString("bitrix.gossite", "coat",  $wizard->GetVar("siteCoatSrc"), WIZARD_SITE_ID, WIZARD_SITE_ID);
COption::SetOptionString("bitrix.gossite", "internet_reception_register_user", "Y", WIZARD_SITE_ID, WIZARD_SITE_ID);
COption::SetOptionString("bitrix.gossite", "request_information_register_user", "Y", WIZARD_SITE_ID, WIZARD_SITE_ID);
COption::SetOptionString('bitrix.gossite', 'installed', "Y", WIZARD_SITE_ID, WIZARD_SITE_ID);
?>