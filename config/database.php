<?php

use function DI\get;
use function DI\create;
use App\Core\Redis\Redis as TechBBRedis;

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
];
