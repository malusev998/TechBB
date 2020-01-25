<?php

use App\Contracts\Hasher;
use App\Services\ArgonHasher;

return [
    Hasher::class => static function () {
        ['ops_limit' => $opsLimit, 'mem_limit' => $memLimit] = require __DIR__.'/hashing.php';

        return new ArgonHasher($opsLimit, $memLimit);
    },
];
