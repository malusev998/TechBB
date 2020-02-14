<?php


namespace App\Core\Http;


use DateTimeInterface;

class UrlService
{
    protected UrlSigner $urlSigner;

    public function __construct(UrlSigner $urlSigner)
    {
        $this->urlSigner = $urlSigner;
    }

    public function sign(string $path, ?DateTimeInterface $expiresIn = null, array $params = []): string
    {
        return $this->urlSigner->sign($path, $expiresIn, $params);
    }

    public function verify(string $url): bool
    {
        return $this->urlSigner->verify($url);
    }
}
