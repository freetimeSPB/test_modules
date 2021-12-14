<?php
namespace Dlukash\Workers;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

Loc::loadMessages(__FILE__);

class StaffTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_dlukash_staff';
    }

    public static function getMap()
    {
        return array(
            new IntegerField('ID', array(
                'autocomplete' => true,
                'primary' => true,
                'title' => Loc::getMessage('WORKERS_DLUKASH_ID'),
            )),
            new StringField('FIO', array(
                'required' => true,
                'title' => Loc::getMessage('WORKERS_DLUKASH_FIO'),
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 255),
                    );
                },
            )),
			new IntegerField('PHONE', array(
                'required' => true,
                'title' => Loc::getMessage('WORKERS_DLUKASH_PHONE'),
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 4),
                    );
                },
            )),
			(new IntegerField('OFFICE_ID')),
            (new Reference(
                    'OFFICE',
                    OfficesTable::class,
                    Join::on('this.OFFICE_ID', 'ref.ID')
                ))
                ->configureJoinType('inner'),
				
	        (new IntegerField('POST_ID')),
            (new Reference(
                    'POST',
                    PostsTable::class,
                    Join::on('this.POST_ID', 'ref.ID')
                ))
                ->configureJoinType('inner'),
        );
    }
}