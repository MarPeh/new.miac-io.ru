<?
set_time_limit(0);

global $MESS;
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang)-18);
include(GetLangFileName($strPath2Lang."/lang/", "/install/index.php")); 

Class bitrix_gossite extends CModule
{
	var $MODULE_ID = "bitrix.gossite";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	public function __construct()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}
		else
		{
			$this->MODULE_VERSION = GOVERNMENT_VERSION;
			$this->MODULE_VERSION_DATE = GOVERNMENT_VERSION_DATE;
		}

		$this->MODULE_NAME = GetMessage("GOVERNMENT_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("GOVERNMENT_MODULE_DESC");
		$this->PARTNER_NAME = GetMessage("GOVERNMENT_PARTNER_NAME");
		$this->PARTNER_URI = GetMessage("GOVERNMENT_PARTNER_URL");
	}

	function InstallDB($arParams = array())
	{
		RegisterModule("bitrix.gossite");

		RegisterModuleDependences('main', 'OnBeforeProlog', 'bitrix.gossite', 'GossiteEvents', 'OnCreatePanel');
		//RegisterModuleDependences('main', 'OnPageStart', 'bitrix.gossite', 'GossiteEvents', 'DetectMobile');
		//RegisterModuleDependences('main', 'OnEndBufferContent', 'bitrix.gossite', 'GossiteEvents', 'gossiteOnEndBufferContent');

		RegisterModuleDependences('form', 'onBeforeResultAdd', 'bitrix.gossite', 'GossiteEvents', 'gossiteOnBeforeResultAdd');
		RegisterModuleDependences('form', 'onAfterResultAdd', 'bitrix.gossite', 'GossiteEvents', 'gossiteOnAfterResultAdd');

		RegisterModuleDependences('iblock', 'OnBeforeIBlockElementAdd', 'bitrix.gossite', 'GossiteEvents', 'gossiteGetObjectMapCoords');
		RegisterModuleDependences('iblock', 'OnBeforeIBlockElementUpdate', 'bitrix.gossite', 'GossiteEvents', 'gossiteGetObjectMapCoords');

		return true;
	}
	function UninstallOldVersion () {
		global $DOCUMENT_ROOT, $APPLICATION;
		if (file_exists($DOCUMENT_ROOT.'/bitrix/modules/gossite/include.php')) {
			UnRegisterModuleDependences('main', 'OnBeforeProlog', 'gossite', 'GossiteEvents', 'OnCreatePanel');
			//UnRegisterModuleDependences('main', 'OnPageStart', 'gossite', 'GossiteEvents', 'DetectMobile');
			//UnRegisterModuleDependences('main', 'OnEndBufferContent', 'gossite', 'GossiteEvents', 'gossiteOnEndBufferContent');

			UnRegisterModuleDependences('form', 'onBeforeResultAdd', 'gossite', 'GossiteEvents', 'gossiteOnBeforeResultAdd');
			UnRegisterModuleDependences('form', 'onAfterResultAdd', 'gossite', 'GossiteEvents', 'gossiteOnAfterResultAdd');

			UnRegisterModuleDependences('iblock', 'OnBeforeIBlockElementAdd', 'gossite', 'GossiteEvents', 'gossiteGetObjectMapCoords');
			UnRegisterModuleDependences('iblock', 'OnBeforeIBlockElementUpdate', 'gossite', 'GossiteEvents', 'gossiteGetObjectMapCoords');
			unlink($DOCUMENT_ROOT.'/bitrix/modules/gossite/include.php');
			unlink($DOCUMENT_ROOT.'/bitrix/modules/gossite/options.php');
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bitrix.gossite/install/old/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/gossite/install/", true, true);
			$arOptions = array(
				'text1',
				'text2',
				'coat',
				'region',
				'animation',
				'demo_type',
				'map_city',
				'internet_reception_form_id',
				'request_information_form_id',
				'internet_reception_form_email',
				'internet_reception_register_user',
				'internet_reception_support_statuse',
				'request_information_form_email',
				'request_information_register_user',
				'request_information_support_statuse',
				'objects_ib',
				'objects_address',
				'objects_lat',
				'objects_lng',
				'routes_types_ib',
				'routes_ib',
				'routes_address',
				'routes_lat',
				'routes_lng',
				'events_ib',
				'events_address',
				'events_lat',
				'events_lng',
				'info_ib_type',
				'indexpage',
				'show_link_map',
			);
			foreach ($arOptions as $optionName) {
				$value = COption::GetOptionString('gossite',$optionName, null);
				if ($value===null) {
					$value = COption::GetOptionString('gossite',$optionName, null,'s1');
				}
				if ($value!==null) {
					COption::SetOptionString('bitrix.gossite',$optionName, $value,'','s1');
				}
			}
			COption::SetOptionString('bitrix.gossite','installed', 'Y','','s1');
		}
	}
	function UnInstallDB($arParams = array())
	{
		UnRegisterModuleDependences('main', 'OnBeforeProlog', 'bitrix.gossite', 'GossiteEvents', 'OnCreatePanel');
		//UnRegisterModuleDependences('main', 'OnPageStart', 'bitrix.gossite', 'GossiteEvents', 'DetectMobile');
		//UnRegisterModuleDependences('main', 'OnEndBufferContent', 'bitrix.gossite', 'GossiteEvents', 'gossiteOnEndBufferContent');

		UnRegisterModuleDependences('form', 'onBeforeResultAdd', 'bitrix.gossite', 'GossiteEvents', 'gossiteOnBeforeResultAdd');
		UnRegisterModuleDependences('form', 'onAfterResultAdd', 'bitrix.gossite', 'GossiteEvents', 'gossiteOnAfterResultAdd');

		UnRegisterModuleDependences('iblock', 'OnBeforeIBlockElementAdd', 'bitrix.gossite', 'GossiteEvents', 'gossiteGetObjectMapCoords');
		UnRegisterModuleDependences('iblock', 'OnBeforeIBlockElementUpdate', 'bitrix.gossite', 'GossiteEvents', 'gossiteGetObjectMapCoords');

		UnRegisterModule("bitrix.gossite");

		return true;
	}

	function InstallEvents()
	{
		return true;
	}

	function UnInstallEvents()
	{
		return true;
	}

	function InstallFiles($arParams = array())
	{
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bitrix.gossite/install/components/gosportal", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components/gosportal", true, true);
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bitrix.gossite/install/gadgets", $_SERVER["DOCUMENT_ROOT"]."/bitrix/gadgets", true, true);
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bitrix.gossite/install/images/coats", $_SERVER["DOCUMENT_ROOT"]."/upload/coats", true, true);
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bitrix.gossite/install/js/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/js/gossite/", true, true);
		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bitrix.gossite/install/wizards/bitrix/gov/_.description.php"))
		{
			rename (
				$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bitrix.gossite/install/wizards/bitrix/gov/_.description.php",
				$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bitrix.gossite/install/wizards/bitrix/gov/.description.php"
			);
		}

		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFilesEx("/upload/coats");
		DeleteDirFilesEx("/bitrix/js/gossite/");
		if (file_exists($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bitrix.gossite/install/wizards/bitrix/gov/.description.php"))
		{
			rename (
				$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bitrix.gossite/install/wizards/bitrix/gov/.description.php",
				$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/bitrix.gossite/install/wizards/bitrix/gov/_.description.php"
			);
		}
		DeleteDirFilesEx("/bitrix/wizards/bitrix/gov/");
		return true;
	}

	function DoInstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION;

		$this->UninstallOldVersion();
		$this->InstallDB();
		$this->InstallFiles();
		$APPLICATION->IncludeAdminFile(GetMessage("GOVERNMENT_INSTALL_TITLE"), $DOCUMENT_ROOT."/bitrix/modules/bitrix.gossite/install/step.php");
	}

	function DoUninstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->UnInstallDB();
		$this->UnInstallFiles();
		$APPLICATION->IncludeAdminFile(GetMessage("GOVERNMENT_UNINSTALL_TITLE"), $DOCUMENT_ROOT."/bitrix/modules/bitrix.gossite/install/unstep.php");
	}
}
?>