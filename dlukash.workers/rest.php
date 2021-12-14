<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use \Bitrix\Main\Loader;

Loader::includeModule('dlukash.workers');

CDlukashWorkers::processRequest(\Bitrix\Main\Context::getCurrent()->getRequest());
