<?php

namespace App\Core\Redis;

use RedisException;
use Redis as PhpRedis;
use App\Core\Contracts\Connection;

class Redis implements Connection
{
    private string $host;
    private int $port;
    private int $database;
    private string $prefix;

    protected static int $refCount = 0;

    protected static ?PhpRedis $connection = null;

    /**
     * Redis constructor.
     *
     * @throws \RedisException
     *
     * @param  int  $port
     * @param  int  $database
     * @param  string  $prefix
     * @param  string  $host
     */
    public function __construct(string $host, ?int $port = null, int $database = 1, string $prefix = 'techbb:')
    {
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->prefix = $prefix;

        if (static::$refCount++ === 0) {
            static::$connection = new PhpRedis();
        }
        $this->init();
    }

    /**
     * @return \Redis
     */
    public function getConnection(): PhpRedis
    {
        return self::$connection;
    }

    /**
     * @throws \RedisException
     */
    private function connect(): void
    {
        if (!static::$connection->isConnected()) {
            // If the port is 0 the connection is going over a unix socket
            if ($this->port === 0) {
                $hasConnected = static::$connection->connect($this->host);
            } else {
                $hasConnected = static::$connection->connect($this->host, $this->port);
            }

            if (!$hasConnected) {
                throw new RedisException('Error while connecting to redis');
            }
        }

        static::$connection->select($this->database);
    }

    /**
     * @throws \RedisException
     *
     * @param $arguments
     * @param $name
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $this->connect();
        return static::$connection->{$name}(...$arguments);
    }

    /**
     * @throws \RedisException
     */
    protected function init(): void
    {
        $this->connect();
        static::$connection->setOption(PhpRedis::OPT_PREFIX, $this->prefix);
        static::$connection->setOption(PhpRedis::OPT_SERIALIZER, PhpRedis::SERIALIZER_PHP);
    }

    public function __destruct()
    {
        if (
            --static::$refCount === 0 &&
            static::$connection !== null &&
            static::$connection->isConnected()
        ) {
            static::$connection->close();
        }
    }
}
