<?php

use App\Services\Auth\LoginService;
use App\Contracts\Auth\LoginContract;

use App\Services\Auth\RegisterService;

use App\Contracts\Auth\RegisterContract;

use function DI\autowire;

return [
    LoginContract::class    => autowire(LoginService::class),
    RegisterContract::class => autowire(RegisterService::class),
];
