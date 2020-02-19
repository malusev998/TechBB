<?php


namespace App\Core\Queue;


use App\Core\Redis\Redis;
use App\Core\Contracts\Queue;
// TODO: Use Z Sets
class RedisQueue implements Queue
{
    private Redis $redis;

    public function __construct(Redis $redis)
    {
        $this->redis = $redis;
    }
}
