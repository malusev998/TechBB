<?php

use App\Kernel;

ini_set('display_errors', 1);
require_once __DIR__.'/../vendor/autoload.php';

$kernel = new Kernel();

try {
    $kernel->run();
} catch (Throwable $e) {
    dump($e);
}
