<?php

use App\Middleware\AuthMiddleware;

use App\Middleware\AnotherMiddleware;

use function DI\autowire;

return [
    'auth'    => autowire(AuthMiddleware::class),
    'another' => autowire(AnotherMiddleware::class),
];
