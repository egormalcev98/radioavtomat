<?

return [
    'index' => [
        'title' => 'Журнал регистрации исходящих документов',
    ],
    'list_columns' => [
        'id' => 'ID',
        'number' => 'Исходящий номер',
        'date' => 'Дата исходящего',
        'counterparty' => 'Получатель',
        'document_type' => 'Вид документа',
        'from_user' => 'От кого',
        'outgoing_doc_status' => 'Статус документа',
        'note' => 'Примечания',
    ],
    'filters' => [
        'period' => 'Период',
        'document_type' => 'Вид документа',
    ],
    'messages' =>[
        'check_number_success' => 'Номер свободен',
        'check_number_fail' => 'Такой номер уже существует',
    ]
];
