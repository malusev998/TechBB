<?php

use function DI\get;
use function DI\create;
use Illuminate\Database\Capsule\Manager;
use App\Core\Redis\Redis as TechBBRedis;

$connections = [
    'mysql' => [
        'driver'    => 'mysql',
        'host'      => $_ENV['DATABASE_HOST'] ?? 'localhost',
        'database'  => $_ENV['DATABASE_NAME'] ?? 'techbb',
        'username'  => $_ENV['DATABASE_USER'] ?? 'root',
        'password'  => $_ENV['DATABASE_PASSWORD'] ?? '',
        'charset'   => $_ENV['DATABASE_CHARSET'] ?? 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix'    => $_ENV['DATABASE_PREFIX'] ?? '',
    ],
];

$manager = new Manager();

$manager->addConnection($connections[$_ENV['DATABASE_DRIVER'] ?? 'mysql']);
$manager->setAsGlobal();
$manager->bootEloquent();

return [
    'redis_host'     => $_ENV['REDIS_HOST'] ?? '127.0.0.1',
    'redis_post'     => $_ENV['REDIS_POST'] ?? 0,
    'redis_database' => $_ENV['REDIS_DATABASE'] ?? 0,
    'redis_prefix'   => $_ENV['REDIS_prefix'] ?? 'techbb',

    TechBBRedis::class => create(TechBBRedis::class)
        ->constructor(
            get('redis_host'),
            get('redis_post'),
            get('redis_database'),
            get('redis_prefix')
        ),
    Manager::class     => $manager,
];
