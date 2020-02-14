<?php

use App\Contracts\Hasher;
use App\Services\ArgonHasher;

use function DI\get;
use function DI\create;

return [
    'ops_limit' => SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE,
    'mem_limit' => SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,

    Hasher::class     => create(ArgonHasher::class)
        ->constructor(get('ops_limit'), get('mem_limit')),
];
