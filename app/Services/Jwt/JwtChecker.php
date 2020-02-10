<?php


namespace App\Services\Jwt;


use Jose\Component\Core\JWT;
use Jose\Component\Signature\JWSVerifier;
use Jose\Component\Checker\AlgorithmChecker;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\JWSTokenSupport;
use Jose\Component\Checker\ClaimCheckerManager;
use Jose\Component\Checker\HeaderCheckerManager;
use Jose\Component\Signature\Serializer\JWSSerializerManager;
use ProxyManager\Signature\Exception\InvalidSignatureException;

class JwtChecker implements \App\Contracts\Jwt\JwtChecker
{
    protected string $publicKey;
    protected array $headerCheckers;
    protected JWSSerializerManager $serializerManager;
    protected JWSVerifier $verifier;
    protected ClaimCheckerManager $claimCheckerManager;

    public function __construct(
        array $keys,
        array $headerCheckers,
        JWSSerializerManager $serializerManager,
        JWSVerifier $verifier,
        ClaimCheckerManager $claimCheckerManager
    ) {
        $this->publicKey = $keys['public'];
        $this->headerCheckers = $headerCheckers;
        $this->serializerManager = $serializerManager;
        $this->verifier = $verifier;
        $this->claimCheckerManager = $claimCheckerManager;
    }


    public function checkHeader(JWT $jwt): void
    {
        $headerChecker = new HeaderCheckerManager(
            [new AlgorithmChecker([$this->headerCheckers['algorithm']])],
            [new JWSTokenSupport()]
        );


        $headerChecker->check($jwt, 0, $this->headerCheckers['mandatory_headers']);
    }


    /**
     * @param  string  $token
     *
     * @return mixed
     */
    public function check(string $token)
    {
        $jws = $this->serializerManager->unserialize($token);

        $key = JWKFactory::createFromKeyFile(
            $this->publicKey,
            null,
            [
                'use' => 'sig',
            ]
        );

        if (!$this->verifier->verifyWithKey($jws, $key, 0)) {
            throw new InvalidSignatureException('Invalid JWT');
        }
        // Verify header
        $this->checkHeader($jws);
        // verify payload
        $payload = json_decode($jws->getPayload(), true, 512, JSON_THROW_ON_ERROR);

        $validated = $this->claimCheckerManager->check($payload);

        return ['payload' => $payload, 'validated_claims' => $validated];
    }
}
