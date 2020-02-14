<?php

use Rakit\Validation\Validator;

use function DI\autowire;

return [
    Validator::class => autowire(Validator::class)
];
