<?php
return [
    'junior' => [
        'type' => 1,
        'description' => 'Младший пользователь',
        'ruleName' => 'userRole',
    ],
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
        'ruleName' => 'userRole',
        'children' => [
            'junior',
        ],
    ],
    'moderator' => [
        'type' => 1,
        'description' => 'Модератор',
        'ruleName' => 'userRole',
        'children' => [
            'user',
        ],
    ],
    'administrator' => [
        'type' => 1,
        'description' => 'Администратор',
        'ruleName' => 'userRole',
        'children' => [
            'moderator',
        ],
    ],
    'developer' => [
        'type' => 1,
        'description' => 'Разработчик',
        'ruleName' => 'userRole',
        'children' => [
            'administrator',
        ],
    ],
];
