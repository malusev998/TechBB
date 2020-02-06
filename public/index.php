<?php

use App\Kernel;
use BrosSquad\DotEnv\EnvParser;
use Symfony\Component\Routing\Exception\NoConfigurationException;

require_once __DIR__.'/../vendor/autoload.php';

$dotnev = new EnvParser(__DIR__.'/../.env');
$kernel = (new Kernel())
    ->setEnvironment(getApplicationEnvironment());

try {
    $dotnev->parse();
    $dotnev->loadIntoENV();
    $kernel->run();
} catch (NoConfigurationException $e) {
    // TODO: Load 404
    echo 'Not Found';
} catch (Throwable $e) {
    echo get_class($e);
    echo $e->getMessage();
}
