<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$menu = array(
    array(
        'parent_menu' => 'global_menu_content',
        'sort' => 400,
        'text' => Loc::getMessage('WORKERS_DLUKASH_MENU_TITLE'),
        'title' => Loc::getMessage('WORKERS_DLUKASH_MENU_TITLE'),
        'url' => 'workers_index.php',
        'items_id' => 'menu_references',
        'items' => array(
            array(
                'text' => Loc::getMessage('WORKERS_DLUKASH_SUBMENU_TITLE'),
                'url' => 'workers_index.php?param1=paramval&lang=' . LANGUAGE_ID,
                'more_url' => array('workers_index.php?param1=paramval&lang=' . LANGUAGE_ID),
                'title' => Loc::getMessage('WORKERS_DLUKASH_SUBMENU_TITLE'),
            ),
        ),
    ),
);

return $menu;
