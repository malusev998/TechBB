<?php

use App\Kernel;
use BrosSquad\DotEnv\EnvParser;

$loader = require __DIR__.'/../vendor/autoload.php';

$dotnev = new EnvParser(__DIR__.'/../.env');
$kernel = (new Kernel())
    ->setEnvironment(getApplicationEnvironment());

$dotnev->parse();
$dotnev->loadIntoENV();
$kernel->run();
