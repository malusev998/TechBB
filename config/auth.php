<?php

use App\Core\Http\JwtAuthGuard;
use App\Core\Contracts\AuthGuard;
use App\Services\Auth\LoginService;
use App\Contracts\Auth\LoginContract;

use App\Services\Auth\RegisterService;

use App\Contracts\Auth\RegisterContract;

use function DI\get;
use function DI\autowire;

return [
    AuthGuard::class        => autowire(JwtAuthGuard::class),
    'default'               => get(AuthGuard::class),
    LoginContract::class    => autowire(LoginService::class),
    RegisterContract::class => autowire(RegisterService::class),
];
