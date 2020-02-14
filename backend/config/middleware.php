<?php


use App\Middleware\CorsMiddleware;

use function DI\autowire;

return [
    'cors' => autowire(CorsMiddleware::class),
];
