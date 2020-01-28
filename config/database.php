<?php

return [
    'mysql' => [
        'driver'    => 'mysql',
        'host'      => $_ENV['DATABASE_HOST'] ?? 'localhost',
        'database'  => $_ENV['DATABASE_NAME'] ?? 'techbb',
        'username'  => $_ENV['DATABASE_USER'] ?? 'root',
        'password'  => $_ENV['DATABASE_PASSWORD'] ?? '',
        'charset'   => $_ENV['DATABASE_CHARSET'] ?? 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => $_ENV['DATABASE_PREFIX'] ?? '',
    ],
];
