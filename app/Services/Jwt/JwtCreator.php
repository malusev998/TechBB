<?php


namespace App\Services\Jwt;


use Carbon\Carbon;
use Carbon\CarbonInterval;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Core\AlgorithmManager;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Serializer\CompactSerializer;

class JwtCreator implements \App\Contracts\Jwt\JwtCreator
{
    protected string $privateKey;
    protected string $issuer;
    protected string $audience;
    protected string $algorithm;
    protected ?string $privateKeyPassword;
    protected AlgorithmManager $algorithmManager;
    protected CarbonInterval $expiresAt;

    public function __construct(
        array $keys,
        string $issuer,
        string $audience,
        array $header,
        AlgorithmManager $algorithmManager,
        CarbonInterval $expiresAt
    ) {
        $this->privateKey = $keys['private'];
        $this->issuer = $issuer;
        $this->audience = $audience;
        $this->algorithm = $header['algorithm'];
        $this->algorithmManager = $algorithmManager;
        $this->expiresAt = $expiresAt;
        $this->privateKeyPassword = $keys['pass'];
    }


    public function create(JwtSubject $user, array $additionalHeader = []): string
    {
        $key = JWKFactory::createFromKeyFile($this->privateKey, $this->privateKeyPassword, ['use' => 'sig']);
        $jwsBuilder = new JWSBuilder($this->algorithmManager);

        $payload = json_encode(
            array_merge(
                $user->getCustomClaims(),
                [
                    'iat' => Carbon::now('UTC')->getTimestamp(),
                    'nbf' => Carbon::now('UTC')->getTimestamp(),
                    'exp' => Carbon::now('UTC')->add($this->expiresAt)->getTimestamp(),
                    'iss' => $this->issuer,
                    'aud' => $this->audience,
                ]
            ),
            JSON_THROW_ON_ERROR,
            512
        );

        $jws = $jwsBuilder
            ->create()
            ->withPayload($payload)
            ->addSignature($key, ['alg' => $this->algorithm], $additionalHeader)
            ->build();

        $serializer = new CompactSerializer();

        return $serializer->serialize($jws);
    }
}
