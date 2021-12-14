<?php
namespace Dlukash\Workers;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;

Loc::loadMessages(__FILE__);

class PostsTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_dlukash_posts';
    }

    public static function getMap()
    {
        return array(
            new IntegerField('ID', array(
                'autocomplete' => true,
                'primary' => true,
                'title' => Loc::getMessage('POSTS_DLUKASH_ID'),
            )),
            new StringField('POST', array(
                'required' => true,
                'title' => Loc::getMessage('POSTS_DLUKASH_POST'),
                'validation' => function () {
                    return array(
                        new Validator\Length(null, 255),
                    );
                },
            )),
			(new OneToMany('STAFF', StaffTable::class, 'POST'))->configureJoinType('inner')
        );
    }
}