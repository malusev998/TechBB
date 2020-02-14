<?php


namespace App\Core\Http;


use DateTimeInterface;

class UrlSigner extends Url
{
    public function sign(string $path, ?DateTimeInterface $expiresIn = null, array $params = []): string
    {
        return '';
    }

    public function verify(string $url): bool
    {
        return false;
    }
}
