<?php

use App\Services\Auth\LoginService;
use App\Contracts\Auth\LoginContract;

use function DI\autowire;

return [
    LoginContract::class => autowire(LoginService::class),
];
