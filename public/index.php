<?php

use App\Kernel;
use BrosSquad\DotEnv\EnvParser;
use BrosSquad\DotEnv\Exceptions\EnvNotParsed;
use BrosSquad\DotEnv\Exceptions\DotEnvSyntaxError;
use BrosSquad\DotEnv\Exceptions\EnvVariableNotFound;

require_once __DIR__.'/../vendor/autoload.php';

$dotnev = new EnvParser(__DIR__.'../.env');
$kernel = (new Kernel())
    ->setEnvironment($_SERVER['TECHBB_ENVIRONMENT']);

try {
    $dotnev->parse();
    $dotnev->loadIntoENV();
    $kernel->run();
} catch (DotEnvSyntaxError $e) {
} catch (EnvVariableNotFound $e) {
} catch (EnvNotParsed $e) {
} catch (Throwable $e) {
} catch (Throwable $e) {
    dump($e);
}
