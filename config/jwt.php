<?php

use Carbon\CarbonInterval;
use App\Services\Jwt\JwtChecker;
use App\Services\Jwt\JwtCreator;
use Jose\Component\Core\AlgorithmManager;

use Jose\Component\Signature\JWSVerifier;

use Jose\Component\Checker\IssuedAtChecker;
use Jose\Component\Checker\AudienceChecker;
use Jose\Component\Checker\NotBeforeChecker;
use Jose\Component\Signature\Algorithm\RS512;
use Jose\Component\Checker\ClaimCheckerManager;
use Jose\Component\Checker\ExpirationTimeChecker;
use App\Contracts\Jwt\JwtCreator as JwtCreatorContract;
use App\Contracts\Jwt\JwtChecker as JwtCheckerContract;
use Jose\Component\Signature\Serializer\CompactSerializer;
use Jose\Component\Signature\Serializer\JWSSerializerManager;

use function DI\get;
use function DI\create;


return [
    'algorithms'                => [new RS512()],
    'header_checkers'           => [
        'algorithm'         => 'RS512',
        'mandatory_headers' => ['alg'],
    ],
    'keys'                      => [
        'public'  => $_ENV['JWT_PUBLIC_KEY'] ?? __DIR__ . '/../keys/public.pem',
        'private' => $_ENV['JWT_PRIVATE_KEY'] ?? __DIR__ . '/../keys/private.pem',
        'pass'    => $_ENV['JWT_PASSWORD'] ?? null,
    ],
    'issuer'                    => $_ENV['JWT_ISSUER'] ?? 'http://localhost',
    'audience'                  => $_ENV['JWT_AUDIENCE'] ?? 'http://localhost:4200',
    AlgorithmManager::class     => create(AlgorithmManager::class)->constructor(get('algorithms')),
    JWSVerifier::class          => create(JWSVerifier::class)->constructor(get(AlgorithmManager::class)),
    JWSSerializerManager::class => create(JWSSerializerManager::class)->constructor([new CompactSerializer()]),
    ClaimCheckerManager::class  => create(ClaimCheckerManager::class)->constructor(
        [
            new IssuedAtChecker(),
            new NotBeforeChecker(),
            new ExpirationTimeChecker(),
            new AudienceChecker($_ENV['JWT_AUDIENCE'] ?? 'http://localhost:4200'),
        ]
    ),

    JwtCheckerContract::class => create(JwtChecker::class)->constructor(
        get('keys'),
        get('header_checkers'),
        get(JWSSerializerManager::class),
        get(JWSVerifier::class),
        get(ClaimCheckerManager::class)
    ),

    JwtCreatorContract::class => create(JwtCreator::class)
        ->constructor(
            get('keys'),
            get('issuer'),
            get('audience'),
            get('header_checkers'),
            get(AlgorithmManager::class),
            get('expires_at')
        ),

    /**
     * Jwt expiration
     */
    'expires_at'                => CarbonInterval::minutes(120),

];
