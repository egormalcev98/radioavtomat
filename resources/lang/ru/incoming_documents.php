<?

return [
	'index' => [
		'title' => 'Журнал регистрации входящих документов',
	],
	'list_columns' => [
		'id' => 'ID',
		'title' => 'Заголовок',
		'created_at' => 'Дата создания',
		'counterparty' => 'Контрагент',
		'number' => 'Исходящий номер',
		'date_letter_at' => 'Исходящая дата',
		'document_type' => 'Вид документа',
		'who_painted' => 'Кем расписано',
		'date_painted' => 'Дата росписи',
		'whom_distributed' => 'Кому распределено',
		'responsibles' => 'Ответственные',
		'note' => 'Примечания',
		'percentage_consideration' => 'Процент рассмотрения',
		'status_name' => 'Статус',
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