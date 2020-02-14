<?php


namespace App\Core;


use BrosSquad\DotEnv\EnvParserInterface;

class Env
{
    protected EnvParserInterface $envParser;
    protected static array $envs;

    public function __construct(EnvParserInterface $envParser) {
        $this->envParser = $envParser;
        $this->load();
    }

    private function load(): void
    {
        if(!isset(static::$envs)) {
            $this->envParser->parse();
            $this->envParser->loadIntoENV();
            $this->envParser->loadUsingPutEnv();
            static::$envs = $this->envParser->getEnvs();
        }
    }

    public function get(string $name, $default = null) {
        return static::$envs[$name] ?? $default;
    }
}
