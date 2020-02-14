<?php

use BrosSquad\DotEnv\EnvParser;

require_once __DIR__.'/vendor/autoload.php';

$envParser = new EnvParser(__DIR__ . '/.env');

$envParser->parse();

$envs = $envParser->getEnvs();

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'production',
        'production' => [
            'adapter' => $envs['DATABASE_DRIVER'],
            'host' => $envs['DATABASE_HOST'] ?? 'localhost',
            'name' => $envs['DATABASE_NAME'] ?? 'techbb',
            'user' => $envs['DATABASE_USER'] ?? 'root',
            'pass' => $envs['DATABASE_PASSWORD'] ?? '',
            'port' => $envs['DATABASE_PORT'] ?? 3306,
            'charset' => $envs['DATABASE_CHARSET'] ?? 'utf8mb4',
        ],
    ],
    'version_order' => 'creation'
];
