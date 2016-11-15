<?
if (IsModuleInstalled('bitrix.gossite')) {
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bitrix.gossite/install/wizards/bitrix/gov/_.description.php")) {
        rename($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bitrix.gossite/install/wizards/bitrix/gov/_.description.php",
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bitrix.gossite/install/wizards/bitrix/gov/.description.php");
    }
}
?>