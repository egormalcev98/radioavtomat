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
			'title' => __('adminlte::menu.incoming_doc_statuses')
		],
		'list_columns' => [
			'id' => 'ID', 
			'name' => 'Название',
		]
	],
];
