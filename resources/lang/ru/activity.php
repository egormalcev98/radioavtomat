<?

return [
    'index' => [
        'title' => 'История',
    ],
    'list_columns' => [
        'id' => 'ID',
        'description' => ' ',
        'created_at' => 'Дата',
        'subject' => 'Документ',
        'causer' => 'Пользователь',
        'document' => '№ :number :title',
    ],
    'filters' => [
        'period' => 'Период',
        'document_type' => 'Вид документа',
        'outgoing_doc_status' => 'Статус документа',
    ],
    'document_not_found' => 'Документ не найден',
];
