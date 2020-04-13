<?

return [
	'index' => [
		'title' => 'Журнал регистрации входящих документов',
	],
	'list_columns' => [
		'id' => 'ID',
		'title' => 'Заголовок',
	],
	'messages' => [
		'check_number_success' => 'Номер свободен',
		'check_number_fail' => 'Такой номер уже существует',
	],
	'users' => [
		'list_columns' => [
			'full_name' => 'ФИО',
			'employee_task_name' => 'Задача',
			'comment' => 'Комментарий',
			'sign_up' => 'Подписать до',
			'signed' => 'Подписан',
		],
		'validation' => [
			'error' => 'Произошла ошибка на этапе валидации',
			'select' => 'Выберите одного или нескольких сотрудников',
		]
	],
];