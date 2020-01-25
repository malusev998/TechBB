<?php

use App\Kernel;

require_once __DIR__.'/../vendor/autoload.php';

$kernel = new Kernel();

try {
    $kernel->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
