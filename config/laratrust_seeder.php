<?php

return [
    'role_structure' => [
    ],
    'permission_structure' => [ // Ключи - id пользователей
        1 => [ 
            'settings' => 'c,r,u,d,v',
            'user' => 'c,r,u,d,v',
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
