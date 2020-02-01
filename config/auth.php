<?php

use App\Services\LoginService;
use App\Contracts\LoginContract;

use function DI\autowire;

return [
    LoginContract::class => autowire(LoginService::class),
];
