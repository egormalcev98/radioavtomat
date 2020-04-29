<?php

/**
 * Файл конфигурации доступов к модулям системы для пользователей
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Список модулей
    |--------------------------------------------------------------------------
    |
    | Массив модулей к которым можно настроить доступы (permissions)
    | Ключ 'name' необходимо указывать идентичный значениям из колонки 'name'
	| таблицы DB permissions без указателя доступа (например вписывать не view_users,
	| а просто users)
	| Массив имеет два уровня вложенности, чтобы можно было настраивать доступ и
	| к определенным методам внутри модулей, например закрывать какие-то поля или
	| даже вкладки с целыми блоками
    |
    */
    'modules' => [
		[
			'name' => 'settings',
			'lang_title' => 'adminlte::menu.settings',
			'dependent' => [],
		],
		[
			'name' => 'user',
			'lang_title' => 'users.index.title',
			'dependent' => [],
		],
		[
			'name' => 'references',
			'lang_title' => 'adminlte::menu.references',
			'dependent' => [],
		],
		[
			'name' => 'incoming_document',
			'lang_title' => 'Карточка нового входящего документа',
			'dependent' => [],
		],
		[
			'name' => 'incoming_card_document',
			'lang_title' => 'Карточка входящего документа',
			'dependent' => [],
		],
        [
            'name' => 'outgoing_document',
            'lang_title' => 'Карточка нового исходящего документа',
            'dependent' => [],
        ],
        [
            'name' => 'outgoing_card_document',
            'lang_title' => 'Карточка исходящего документа',
            'dependent' => [],
        ],
        [
            'name' => 'activity',
            'lang_title' => 'adminlte::menu.activity',
            'dependent' => [],
        ],
		[
			'name' => 'reports',
			'lang_title' => 'adminlte::menu.reports',
			'dependent' => [],
		],
        [
            'name' => 'note',
            'lang_title' => 'adminlte::menu.notes',
            'dependent' => [],
        ],
        [
            'name' => 'task',
            'lang_title' => 'adminlte::menu.tasks',
            'dependent' => [],
        ],
    ],

];
