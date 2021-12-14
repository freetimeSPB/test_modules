<?php
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Dlukash\Workers\StaffTable;
use Dlukash\Workers\OfficesTable;
use Dlukash\Workers\PostsTable;
use Dlukash\Workers\UsersTable;

Loc::loadMessages(__FILE__);

class dlukash_workers extends CModule
{
    public function __construct()
    {
        $arModuleVersion = array();
        
        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
        
        $this->MODULE_ID = 'dlukash.workers';
        $this->MODULE_NAME = Loc::getMessage('WORKERS_DLUKASH_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('WORKERS_DLUKASH_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('WORKERS_DLUKASH_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = 'https://bitrix.ru';
    }

    public function doInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        $this->installDB();
		$this->InstallFiles();
    }

    public function doUninstall()
    {
        $this->uninstallDB();
		$this->UnInstallFiles();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

	function InstallFiles() {
       
	   \CUrlRewriter::Add(array (
			'CONDITION' => '#^/api/#',
			'RULE' => '',
			'ID' => NULL,
			'PATH' => "/local/modules/" . $this->MODULE_ID . "/rest.php",
			'SORT' => 100,
		  ));
		return true;
	}

	function UnInstallFiles() {
		
		\CUrlRewriter::Delete(array("CONDITION" => "#^/api/#", "PATH" => "/local/modules/" . $this->MODULE_ID . "/rest.php"));
		return true;
	}
	
    public function installDB()
    {
        if (Loader::includeModule($this->MODULE_ID))
        {
            StaffTable::getEntity()->createDbTable();
            PostsTable::getEntity()->createDbTable();
            OfficesTable::getEntity()->createDbTable();
            UsersTable::getEntity()->createDbTable();
			
			$this->fillDBData();
        }
		
    }
	
    private function fillDBData(){
		global $DB;
		$DB->RunSQLBatch(dirname(__FILE__)."/sql/data.sql");
	}
	
    public function uninstallDB()
    {
        if (Loader::includeModule($this->MODULE_ID))
        {
            $connection = Application::getInstance()->getConnection();
            $connection->dropTable(StaffTable::getTableName());
            $connection->dropTable(PostsTable::getTableName());
            $connection->dropTable(OfficesTable::getTableName());
            $connection->dropTable(UsersTable::getTableName());
        }
    }
}


 