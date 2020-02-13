<?php

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/helpers.php';

return [
    'db' => [
        'dsn' => 'mysql:dbname=rosberry;host=localhost',
        'user' => 'dbuser',
        'pass' => 'dbpassword',
    ],

    'routes' => [
        'GET' => [
            '/users' => '\App\UsersController@index',
        ],

        'POST' => [
            '/users' => '\App\UsersController@create',
            '/login' => '\App\UsersController@login'
        ],

        'PUT' => [
            '/users' => '\App\UsersController@update',
            '/users/settings' => '\App\UsersController@updateSettings',
        ],
    ],
];
