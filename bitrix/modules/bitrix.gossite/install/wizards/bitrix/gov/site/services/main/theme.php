<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!defined("WIZARD_TEMPLATE_ID"))
	return;

$templateDir = BX_PERSONAL_ROOT."/templates/".WIZARD_TEMPLATE_ID."_".WIZARD_THEME_ID."_".WIZARD_SITE_ID;

CopyDirFiles(
	WIZARD_THEME_ABSOLUTE_PATH,
	$_SERVER["DOCUMENT_ROOT"].$templateDir,
	$rewrite = true,
	$recursive = true,
	$delete_after_copy = false,
	$exclude = "description.php"
);

CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"].$templateDir."/header.php", Array("SITE_DIR" => WIZARD_SITE_DIR));
CWizardUtil::ReplaceMacros($_SERVER["DOCUMENT_ROOT"].$templateDir."/footer.php", Array("SITE_DIR" => WIZARD_SITE_DIR));

COption::SetOptionString("main", "wizard_".WIZARD_TEMPLATE_ID."_theme_id", WIZARD_THEME_ID, "", WIZARD_SITE_ID);
?>