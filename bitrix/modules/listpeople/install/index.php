<?
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

Class listpeople extends CModule
{
	var $MODULE_ID = "listpeople";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

	function listpeople()
	{
		$arModuleVersion = array();

		include(__DIR__.'/version.php');

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = "модуль списка людей";
		$this->MODULE_DESCRIPTION = "тест";
	}


	function InstallDB($install_wizard = true)
	{

		global $DB, $DBType, $APPLICATION;



		$errors = null;
		if (!$DB->Query("SELECT * FROM students", true))
			$errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/listpeople/install/db/mysql/install.sql");

		if (!empty($errors))
		{
			$APPLICATION->ThrowException(implode("", $errors));
			return false;
		}

		RegisterModule("listpeople");
		return true;
	}

	function UnInstallDB($arParams = Array())
	{
		global $DB, $DBType, $APPLICATION;

		$errors = null;
		if(array_key_exists("savedata", $arParams) && $arParams["savedata"] != "Y")
		{
			$errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/listpeople/install/db/mysql/uninstall.sql");

			if (!empty($errors))
			{
				$APPLICATION->ThrowException(implode("", $errors));
				return false;
			}
			\Bitrix\Main\Config\Option::delete($this->MODULE_ID);
		}


		UnRegisterModule("listpeople");

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

	function InstallFiles()
	{
		if($_ENV["COMPUTERNAME"]!='BX')
		{
			CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/listpeople/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components/test", true, true);
		}
		return true;
	}

	function UnInstallFiles()
	{
		if($_ENV["COMPUTERNAME"]!='BX')
		{

			if (is_dir($p = $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/listpeople/install/components"))
			{
				foreach (scandir($p) as $item)
				{
					if ($item == '..' || $item == '.')
						continue;

					DeleteDirFilesEx('/bitrix/components/test/'.$item);
				}
			}
		}

		return true;
	}

	function DoInstall()
	{
		$this->InstallFiles();
		$this->InstallDB(true);

	}

	function DoUninstall()
	{
		$this->UnInstallDB();
		$this->UnInstallFiles();
	}
}
?>
