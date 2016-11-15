<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (!defined("WIZARD_SITE_ID"))
	return;

if (!defined("WIZARD_SITE_DIR"))
	return;

function ___writeToAreasFile($fn, $text)
{
    if (file_exists($fn) && !is_writable($abs_path) && defined("BX_FILE_PERMISSIONS")) {
        @chmod($abs_path, BX_FILE_PERMISSIONS);
    }

    $fd = @fopen($fn, "wb");
    if (!$fd) {
        return false;
    }

    if (false === fwrite($fd, $text)) {
        fclose($fd);

        return false;
    }

    fclose($fd);

    if (defined("BX_FILE_PERMISSIONS")) {
        @chmod($fn, BX_FILE_PERMISSIONS);
    }
}
$wizard =& $this->GetWizard();
$suffix = substr($wizard->GetVar("typeID"), 5);
if (COption::GetOptionString("bitrix.gossite", "demo_type", "", WIZARD_SITE_ID) === "") {

    $path   = str_replace("//", "/", WIZARD_ABSOLUTE_PATH . "/site/public/common/upload/");
    $handle = @opendir($path);
    if ($handle) {
        while ($file = readdir($handle)) {
            if (in_array($file, array(".", ".."))) {
                continue;
            }

            CopyDirFiles(
                $path . $file,
                $_SERVER['DOCUMENT_ROOT'] . '/' . COption::GetOptionString("main", "upload_dir", "upload") . '/' . $file,
                $rewrite = false,
                $recursive = true,
                $delete_after_copy = false
            );
        }
    }

    $path   = str_replace("//", "/", WIZARD_ABSOLUTE_PATH . "/site/public/" . LANGUAGE_ID . "/common/");
    $handle = @opendir($path);
    if ($handle) {
        while ($file = readdir($handle)) {
            if (in_array($file, array(".", ".."))) {
                continue;
            }

            CopyDirFiles($path . $file, WIZARD_SITE_PATH . $file, $rewrite = true, $recursive = true,
                $delete_after_copy = false);
        }
    }

    $path   = str_replace("//", "/", WIZARD_ABSOLUTE_PATH . "/site/public/" . LANGUAGE_ID . "/" . $suffix . "/");
    $handle = @opendir($path);
    if ($handle) {
        while ($file = readdir($handle)) {
            if (in_array($file, array(".", ".."))) {
                continue;
            }

            CopyDirFiles($path . $file, WIZARD_SITE_PATH . $file, $rewrite = true, $recursive = true,
                $delete_after_copy = false);
        }
    }

    // User lang
    CopyDirFiles(str_replace("//", "/", WIZARD_ABSOLUTE_PATH . "/site/php_interface"),
        $_SERVER["DOCUMENT_ROOT"] . BX_PERSONAL_ROOT . "/php_interface", $rewrite = true, $recursive = true,
        $delete_after_copy = false);

    CModule::IncludeModule("search");
    CSearch::ReIndexAll(false, 0, Array(WIZARD_SITE_ID, WIZARD_SITE_DIR));

    WizardServices::PatchHtaccess(WIZARD_SITE_PATH);
    WizardServices::ReplaceMacrosRecursive(WIZARD_SITE_PATH, Array("SITE_DIR" => WIZARD_SITE_DIR));
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "_index.php", Array("SITE_DIR" => WIZARD_SITE_DIR));

    $arUrlRewrite = array();
    if (file_exists(WIZARD_SITE_ROOT_PATH . "/urlrewrite.php")) {
        include(WIZARD_SITE_ROOT_PATH . "/urlrewrite.php");
    }

    require('url/common.php');
    foreach ($arNewUrlRewrite as $arUrl) {
        if (!in_array($arUrl, $arUrlRewrite)) {
            CUrlRewriter::Add($arUrl);
        }
    }

    require('url/' . $suffix . '.php');
    foreach ($arNewUrlRewrite as $arUrl) {
        if (!in_array($arUrl, $arUrlRewrite)) {
            CUrlRewriter::Add($arUrl);
        }
    }

    foreach ($arNewUrlRewrite as $arUrl) {
        if (!in_array($arUrl, $arUrlRewrite)) {
            CUrlRewriter::Add($arUrl);
        }
    }
} elseif (version_compare(COption::GetOptionString("bitrix.gossite", "template_version", false, WIZARD_SITE_ID), '4.0.0') < 0) {
    $renameSuffix = 'old.v3';
    $path   = str_replace("//", "/", WIZARD_ABSOLUTE_PATH . "/site/public/" . LANGUAGE_ID . "/");
    //Replace index.php
    if (file_exists($path . "/" . $suffix . "/_index.php")) {
        rename(WIZARD_SITE_PATH.'index.php', WIZARD_SITE_PATH.'index_'.$renameSuffix.'.php');
        copy($path . "/" . $suffix . "/_index.php", WIZARD_SITE_PATH.'_index.php');
    } elseif (file_exists($path . "/common/_index.php")) {
        rename(WIZARD_SITE_PATH.'index.php', WIZARD_SITE_PATH.'index_'.$renameSuffix.'.php');
        copy($path . "/common/_index.php", WIZARD_SITE_PATH.'_index.php');
    }
    CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'_index.php', Array("SITE_DIR" => WIZARD_SITE_DIR));
    //Replace gosserv file
    if ($suffix == 'pov') {
        if (file_exists(WIZARD_SITE_PATH."gosserv/index.php")) {
            rename(WIZARD_SITE_PATH.'gosserv/index.php', WIZARD_SITE_PATH.'gosserv/index_'.$renameSuffix.'.php');
            copy($path."/".$suffix."/activity/gosserv/index.php", WIZARD_SITE_PATH.'gosserv/index.php');
        }
        if (file_exists(WIZARD_SITE_PATH."activity/gosserv/index.php")) {
            rename(WIZARD_SITE_PATH.'activity/gosserv/index.php', WIZARD_SITE_PATH.'activity/gosserv/index_'.$renameSuffix.'.php');
            copy($path."/".$suffix."/activity/gosserv/index.php", WIZARD_SITE_PATH.'activity/gosserv/index.php');
            CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'activity/gosserv/index.php', Array("SITE_DIR" => WIZARD_SITE_DIR));
        }
    } else {
        if (file_exists(WIZARD_SITE_PATH."gosserv/index.php")) {
            rename(WIZARD_SITE_PATH.'gosserv/index.php', WIZARD_SITE_PATH.'gosserv/index_'.$renameSuffix.'.php');
            copy($path."/".$suffix."/gosserv/index.php", WIZARD_SITE_PATH.'gosserv/index.php');
            CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH.'gosserv/index.php', Array("SITE_DIR" => WIZARD_SITE_DIR));
        }
    }

    $arUrlRewrite = array();
    if (file_exists(WIZARD_SITE_ROOT_PATH . "/urlrewrite.php")) {
        include(WIZARD_SITE_ROOT_PATH . "/urlrewrite.php");
        require('url/common.php');
        foreach ($arNewUrlRewrite as $arUrl) {
            if (!in_array($arUrl, $arUrlRewrite)) {
                CUrlRewriter::Add($arUrl);
            }
        }

        require('url/'.$suffix.'.php');
        foreach ($arNewUrlRewrite as $arUrl) {
            if (!in_array($arUrl, $arUrlRewrite)) {
                CUrlRewriter::Add($arUrl);
            }
        }
    }
}

CheckDirPath(WIZARD_SITE_PATH . "includes/");

___writeToAreasFile(WIZARD_SITE_PATH . "includes/title.php", $wizard->GetVar("siteName"));

___writeToAreasFile(WIZARD_SITE_PATH . "includes/top-address.php", $wizard->GetVar("siteTopAddress"));
___writeToAreasFile(WIZARD_SITE_PATH . "includes/top-address-desc.php", GetMessage("INC_TOP_ADDRESS_DESC"));

___writeToAreasFile(WIZARD_SITE_PATH . "includes/top-phone.php", $wizard->GetVar("siteTopPhone"));
___writeToAreasFile(WIZARD_SITE_PATH . "includes/top-phone-desc.php", GetMessage("INC_TOP_PHONE_DESC"));

___writeToAreasFile(WIZARD_SITE_PATH . "includes/home-feedback-text1.php", GetMessage("INC_FEEDBACK_1"));
___writeToAreasFile(WIZARD_SITE_PATH . "includes/home-feedback-text2.php", GetMessage("INC_FEEDBACK_2"));

___writeToAreasFile(WIZARD_SITE_PATH . "includes/bottom-address.php",
    $wizard->GetVar("siteTopAddress") . "<br>" . $wizard->GetVar("siteTopPhone"));
___writeToAreasFile(WIZARD_SITE_PATH . "includes/copyright.php", $wizard->GetVar("siteName"));

CWizardUtil::ReplaceMacros(WIZARD_SITE_PATH . "includes/welcome.php",
    Array("SITE_DIR" => WIZARD_SITE_DIR, "SITE_NAME" => $wizard->GetVar("siteName")));
?>
