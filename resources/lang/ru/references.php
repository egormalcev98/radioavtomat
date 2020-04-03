<?php

return [
	'main' => [
		'create_element' => 'Создать',
		'create_text_template' => 'создать',
		'edit_text_template' => 'редактировать',
		'show_text_template' => 'просмотр',
		'flash_success_create' => 'Элемент создан',
		'flash_success_update' => 'Элемент отредактирован',
		'edit_button' => 'Редактировать',
		'delete_button' => 'Удалить',
		'action_column' => 'Действие',
		'save_button' => 'Сохранить',
		'cancel_button' => 'Отмена',
		'close_button' => 'Закрыть',
		'search' => 'Поиск',
		'action_edit_column' => '', //'Редактировать',
		'action_delete_column' => '', //'Удалить',
		'error_repeat' => 'Произошла ошибка, попробуйте еще раз',
		'validation' => [
			'name_required' => 'Поле Название обязательно для заполнения.',
		]
	],
	
	'document_types' => [
		'index' => [
			'title' => __('adminlte::menu.document_types')
		],
		'list_columns' => [
			'id' => 'ID', 
			'name' => 'Название',
		]
	],
	
	'incoming_doc_statuses' => [
		'index' => [
			'title' => 'Статусы входящих документов'
		],
		'list_columns' => [
			'id' => 'ID', 
			'name' => 'Название',
		]
	],
	
	'outgoing_doc_statuses' => [
		'index' => [
			'title' => 'Статусы исходящих документов'
		],
		'list_columns' => [
			'id' => 'ID', 
			'name' => 'Название',
		]
	],
	
	'employee_tasks' => [
		'index' => [
			'title' => __('adminlte::menu.employee_tasks')
		],
		'list_columns' => [
			'id' => 'ID', 
			'name' => 'Название',
		]
	],
	
	'letter_forms' => [
		'index' => [
			'title' => __('adminlte::menu.letter_forms')
		],
		'list_columns' => [
			'id' => 'ID', 
			'name' => 'Название',
		]
	],
	
	'task_statuses' => [
		'index' => [
			'title' => __('adminlte::menu.task_statuses')
		],
		'list_columns' => [
			'id' => 'ID', 
			'name' => 'Название',
		]
	],
	
	'event_types' => [
		'index' => [
			'title' => __('adminlte::menu.event_types')
		],
		'list_columns' => [
			'id' => 'ID', 
			'name' => 'Название',
		]
	],
	
	'category_notes' => [
		'index' => [
			'title' => 'Категории служебных записок'
		],
		'list_columns' => [
			'id' => 'ID', 
			'name' => 'Название',
		]
	],
	
	'status_notes' => [
		'index' => [
			'title' => 'Статусы служебных записок'
		],
		'list_columns' => [
			'id' => 'ID', 
			'name' => 'Название',
		]
	],
	
	'user_statuses' => [
		'index' => [
			'title' => __('adminlte::menu.user_statuses')
		],
		'list_columns' => [
			'id' => 'ID', 
			'name' => 'Название',
		]
	],
	
	'structural_units' => [
		'index' => [
			'title' => 'Структурные подразделения'
		],
		'list_columns' => [
			'id' => 'ID', 
			'name' => 'Название',
		]
	],
	
	'roles' => [
		'index' => [
			'title' =>  __('adminlte::menu.roles')
		],
		'list_columns' => [
			'id' => 'ID', 
			'display_name' => 'Название',
		]
	],
	
];
