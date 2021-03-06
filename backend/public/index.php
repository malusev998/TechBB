<?php

use App\Kernel;
use BrosSquad\DotEnv\EnvParser;
use Doctrine\Common\Annotations\AnnotationRegistry;


$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

try {
    $dotnev = new EnvParser(__DIR__.'/../.env');
    $kernel = (new Kernel())
        ->setEnvironment(getApplicationEnvironment());


    $dotnev->parse();
    $dotnev->loadIntoENV();
    $kernel->run();
} catch (Throwable| Error $e) {
    echo $e->getMessage();
}
