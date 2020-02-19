<?php


namespace App\Core\Redis;

use Redis as PhpRedis;

interface RedisSerializer
{
    public const IGBINARY = PhpRedis::SERIALIZER_IGBINARY;
    public const JSON     = PhpRedis::SERIALIZER_JSON;
    public const PHP      = PhpRedis::SERIALIZER_PHP;
    public const MSGPACK  = PhpRedis::SERIALIZER_MSGPACK;
    public const NONE     = PhpRedis::SERIALIZER_NONE;

    public function setSerializer(int $option): void;

    public function getDefaultSerializer(): int;

    public function setDefaultSerializer(): void;
}
