<?php

if (IsModuleInstalled('bitrix.gossite')) {
    # Copy files

    DeleteDirFilesEx("/bitrix/wizards/bitrix/government/");

    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bitrix.gossite/install/wizards/bitrix/government/.description.php")) {
        rename($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bitrix.gossite/install/wizards/bitrix/government/.description.php",
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bitrix.gossite/install/wizards/bitrix/government/_.description.php");
    }
}