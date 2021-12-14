<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Dlukash\Workers\{StaffTable, OfficesTable, PostsTable, UsersTable};

IncludeModuleLangFile( __FILE__ );

class CDlukashWorkers
{
    static $moduleId = null;

    public static function getModuleId()
    {
        if (is_null(self::$moduleId)) {
            self::$moduleId = basename(dirname(__FILE__));
        }

        return self::$moduleId;
    }
	
	public static function processRequest($request)
    {
	  $result='';
	  $arRequest = $request->getQueryList()->toArray();
	  
      if(self::checkUser($arRequest["login"], $arRequest["passwd"])){
		  unset($arRequest["login"]);
		  unset($arRequest["passwd"]);
	  }
	  
      self::routeMethod($arRequest);
	}
	
	private static function checkUser($login, $passwd)
    {
	  if(empty($login) || empty($passwd)){
		  self::makeJsonReply(array(), true, 'zero login or pass');
	  } else {
		  $rsUsers = UsersTable::getList([
		    'filter'=> [
			    '=LOGIN' => $login,
			    '=PASSWD' => $passwd,
		    ],
            'select' => [
                'ID'
            ],
			'limit' => 1
        ]);
		
		if ($rsUsers->getSelectedRowsCount() > 0) {
            $arUser = $rsUsers->fetch();
			
			if($arUser['ID']>0)
				UsersTable::update($arUser['ID'], array('LAST_AUTH' => new \Bitrix\Main\Type\DateTime()));
		
        } else {
			self::makeJsonReply(array(), true, 'unknown user');
		}
		
	  }
	  return true;	  
	}
	
	private static function routeMethod($arRequest)
    {
	  if(empty($arRequest['method'])){
		  self::makeJsonReply(array(), true, 'zero method');
	  } else {
		  
		  $method = $arRequest['method'];
		  unset ($arRequest['method']);
		  
		  switch ($method) {
			case 'search':
			
				if(!empty($arRequest['fio']))
					self::findStaffByFIO($arRequest['fio']);
				else
					self::makeJsonReply(array(), true, 'empty params');
				break;
				
			case 'update':
			
				$ID = $arRequest['id'];
				unset ($arRequest['id']);
		  
			    if($ID>0){
					self::updateStaffByID($ID, $arRequest);
				}
				else{
					self::makeJsonReply(array(), true, 'empty params');
				}
				break;
			case 'offices':
				self::getAllOfficesWithID();
				break;
			default:
				self::makeJsonReply(array(), true, 'unknown method');
		}
	  }
	  return true;	  
	}
	
	public static function getAllStaffWithID()
    {
		
		$rsStaff = StaffTable::getList([
            'select' => [
                'ID', 'FIO'
            ]
        ]);
		
		$ar=array();
		
        if ($rsStaff->getSelectedRowsCount() > 0) {
            $ar = $rsStaff->fetchAll();
        }
		
		self::makeJsonReply($ar);
		
		return true;
     }
	
	public static function getAllOfficesWithID()
    {
		$rsOffices = OfficesTable::getList([
            'select' => [
                'ID', 'OFFICE'
            ]
        ]);
		
		$ar=array();
		
        if ($rsOffices->getSelectedRowsCount() > 0) {
            $ar = $rsOffices->fetchAll();
        }
		
		self::makeJsonReply($ar);
		
		return true;
	}
	
	public static function getAllStaffWithOffice()
    {
		$rsStaff = StaffTable::getList([
            'select' => [
                'ID', 'FIO', 'POSITION' => 'POST.POST', 'PHONE', 'OFFICE_NAME' => 'OFFICE.OFFICE', 'OFFICE_ADRESS' => 'OFFICE.ADRESS'
            ]
        ]);
		
		$ar=array();

        if ($rsStaff->getSelectedRowsCount() > 0) {
            $ar = $rsStaff->fetchAll();
        }
		
		self::makeJsonReply($ar);
		
		return true;
	}
	
    public static function addStaff(array $arFields)
    {
		if (!empty($arFields)){
			
			 $res = StaffTable::add($arFields);

			if (!$res->isSuccess())
			{
				self::makeJsonReply(array(), true, implode(',', $res->getErrorMessages()));
			} else {
				$ID = $res->getId();
				self::makeJsonReply(array('ID'=>$ID));
			}
			
		} else {
			self::makeJsonReply(array(), true, 'empty Fields');
		}
		
		return true;
	}
	
	public static function updateStaffByID(int $ID, array $arFields)
    {
		if ($ID > 0){
			$res = StaffTable::update($ID, $arFields);
			
			if (!$res->isSuccess())
			{
				self::makeJsonReply(array(), true, implode(',', $res->getErrorMessages()));
			} else {
				self::makeJsonReply(array('ID'=>$ID));
			}
		
		} else {
			self::makeJsonReply(array(), true, 'zero ID');
		}
		
		return true;
	}
	
	public static function deleteStaffByID(int $ID)
    {
		if ($ID > 0){
			$res = StaffTable::delete($ID);
			
			if(!$res->isSuccess())
			{
				self::makeJsonReply(array(), true, $res->getErrorMessages());
			} else {
				self::makeJsonReply(array('ID'=>$ID));
			}
		} else {
			self::makeJsonReply(array(), true, 'zero ID');
		}
		
		return true;
	}
	
	public static function findStaffByFIO(string $FIO)
    {
		if (strlen($FIO) > 0){
			
			$rsStaff = StaffTable::getList([
			'filter' => [
			  '%=FIO' => '%'.$FIO.'%'
			],
            'select' => [
                'ID', 'FIO'
				]
			]);
			
			$ar=array();

			if ($rsStaff->getSelectedRowsCount() > 0) {
				$ar = $rsStaff->fetchAll();
			}
			
			self::makeJsonReply($ar);
			
		} else {
			self::makeJsonReply(array(), true, 'zero FIO');
		}
		
		return true;
	}
	
	private function makeJsonReply(array $data, bool $error = false, string $errmsg=''){
		
		if(!$error){
			$arReply = array('status_answer' => 'ok', 'out' => $data);
		} else {
			$arReply = array('status_answer' => 'error', 'status_message' => $errmsg);
		}

		try {
			    $result = \Bitrix\Main\Web\Json::encode($arReply);
			} catch (\Bitrix\Main\SystemException $e) {
				$result = \Bitrix\Main\Web\Json::encode(array('status_answer' => 'error', 'status_message' => $e->getMessage()));
			}
		
		header('Content-Type: application/json');
		echo json_encode($result);
		exit;
	}
}