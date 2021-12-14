<?php
namespace Dlukash\Workers;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Entity\DatetimeField;

Loc::loadMessages(__FILE__);

class UsersTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_dlukash_users';
    }

    public static function getMap()
    {
        return array(
            new IntegerField('ID', array(
                'autocomplete' => true,
                'primary' => true,
                'title' => Loc::getMessage('USERS_DLUKASH_ID'),
            )),
            new StringField('LOGIN', array(
                'required' => true,
                'title' => Loc::getMessage('USERS_DLUKASH_LOGIN'),
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 30),
                    );
                },
            )),
			new StringField('PASSWD', array(
                'required' => true,
                'title' => Loc::getMessage('USERS_DLUKASH_PASSWD'),
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 30),
                    );
                },
            )),
			 new DatetimeField('LAST_AUTH',array(
                'required' => true,
				'title' => Loc::getMessage('USERS_DLUKASH_LAST_AUTH')),
				),
        );
    }
}