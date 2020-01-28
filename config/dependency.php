<?php

use App\Contracts\Hasher;
use App\Services\ArgonHasher;
use Illuminate\Database\Capsule\Manager;

$connections = require __DIR__ . '/database.php';

$manager = new Manager();

$manager->addConnection($connections[$_ENV['DATABASE_DRIVER'] ?? 'mysql']);
$manager->setAsGlobal();
$manager->bootEloquent();

return [
    Hasher::class => static function () {
        ['ops_limit' => $opsLimit, 'mem_limit' => $memLimit] = require __DIR__.'/argon2.php';
        return new ArgonHasher($opsLimit, $memLimit);
    },
    'db_connections' => $connections,
    Manager::class => static fn () => $manager,
];
