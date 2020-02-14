<?php


namespace App\Core\Http;


abstract class Url
{
    protected string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }
}
