<?php

return [
    'role_structure' => [
    ],
    'permission_structure' => [ // Ключи - id пользователей
        1 => [
            'settings' => 'c,r,u,d,v',
            'user' => 'c,r,u,d,v',
            'references' => 'c,r,u,d,v',
            'incoming_document' => 'c,r,u,d,v',
            'outgoing_document' => 'c,r,u,d,v',
            'activity' => 'c,r,u,d,v',
            'incoming_card_document' => 'c,r,u,d,v',
            'outgoing_card_document' => 'c,r,u,d,v',
            'reports' => 'c,r,u,d,v',
            'note' => 'c,r,u,d,v',
            'note_card' => 'c,r,u,d,v',
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
		'v' => 'view',
    ]
];
