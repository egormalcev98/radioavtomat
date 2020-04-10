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
			'id' => 'ID',
		],
		'validation' => [
			'error' => 'Произошла ошибка на этапе валидации',
			'select' => 'Выберите одного или нескольких сотрудников',
		]
	],
];