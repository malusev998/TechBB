<?php

namespace App\Core\Redis;

use RedisException;
use Redis as PhpRedis;
use DateTimeInterface;
use Carbon\CarbonInterface;
use App\Core\Contracts\Connection;


/**
 * Class Redis
 *
 * @package App\Core\Redis
 * @method bool isConnected()
 * @method string|bool getHost() The host or unix socket we're connected to or FALSE if we're not connected
 * @method int|bool getPort() Returns the port we're connected to or FALSE if we're not connected
 * @method int|bool getDbNum()  Returns the database number (int)phpredis thinks it's pointing to or FALSE if we're not
 *     connected
 * @method float|bool getTimeout() The timeout (DOUBLE)specified in our connect call or FALSE if we're not connected
 * @method float|bool getReadTimeout() Returns the read timeout (which can be set using setOption and
 *     Redis::OPT_READ_TIMEOUT) or FALSE if we're not connected
 * @method string|null|bool getPersistentID() Returns the persistent id phpredis is using (which will only be set if
 *     connected with pconnect), NULL if we're not using a persistent ID, and FALSE if we're not connected
 * @method string|null|bool getAuth() Returns the password used to authenticate a phpredis session or NULL if none was
 *     used, and FALSE if we're not connected
 * @method bool swapdb(int $db1, int $db2) TRUE on success and FALSE on failure
 * @method mixed|null getOption()  Parameter value
 * @method string ping() Throws a RedisException object on connectivity error, as described above.
 * @method string echo (string $message)
 * @method string|mixed|bool get(string $key)  If key didn't exist, FALSE is returned. Otherwise, the value related to
 *     this key is returned
 * @method bool set(string $key, mixed $value, $timeout = null)
 * @method bool setex(string $key, int|DateTimeInterface|CarbonInterface $ttl, mixed $value) Set the string value in
 *     argument as value of the key, with a time to live.
 * @method bool psetex(string $key, int|DateTimeInterface $ttl, mixed $value) Set the string value in argument as
 *     value of the key, with a time to live.
 * @method bool setnx(string $key, mixed $value) Set the string value in argument as value of the key if the key
 *     doesn't already exist in the database.
 * @method int del(string|array|int $key1, ...$otherKeys) Remove specified keys.
 * @method int unlink(string|string[] $key1, string $key2 = null, string $key3 = null) Delete a key asynchronously in
 *     another thread. Otherwise it is just as DEL, but non blocking.
 * @method PhpRedis multi(int $mode)  returns the Redis instance and enters multi-mode. Once in multi-mode, all
 *     subsequent method calls return the same object until exec() is called.
 * @method void|array exec()
 * @method void discard()
 * @method void watch(string|string[] $key) Watches a key for modifications by another client. If the key is modified
 *     between WATCH and EXEC, the MULTI/EXEC transaction will fail (return FALSE). unwatch cancels all the watching of
 *     all keys by this client.
 * @method void unwatch()
 * @method mixed|null subscribe(string[] $channels, callable $callback) Any non-null return value in the callback will
 *     be returned to the caller.
 * @method mixed|null psubscribe(string[] $channels, callable $callback)
 * @method int publish(string $channel, string $message) Publish messages to channel.
 * @method array|int pubsub(string $keyword, string|array $argument)  A command allowing you to get information on the
 *     Redis pub/sub system
 * @method void unsubscribe(string[] $channels)
 * @method void punsubscribe(string[] $channels)
 * @method int|bool exists(string[]|string $key)  Verify if the specified key/keys exists, returns the number of keys
 *     tested that do exist
 * @method int incr(string $key) Increment the number stored at key by one.
 * @method float incrByFloat(string $key, float $increment) Increment the float value of a key by the given amount
 * @method int incrBy(string $key, int $value) Increment the number stored at key by one. If the second argument is
 *     filled, it will be used as the integer value of the increment.
 * @method int decr(string $key)
 * @method int decrBy(string $key, int $value)  Decrement the number stored at key by one. If the second argument is
 *     filled, it will be used as the integer value of the decrement.
 * @method int|bool lPush(string $key, string|mixed ...$value) Adds the string values to the head (left) of the list.
 *     Creates the list if the key didn't exist. If the key exists and is not a list, FALSE is returned.
 * @method int|bool rPush(string $key, string|mixed ...$value) Adds the string values to the tail (right) of the list.
 *     Creates the list if the key didn't exist. If the key exists and is not a list, FALSE is returned.
 * @method int|bool lPushx(string $key, mixed $value) Adds the string value to the head (left) of the list if the list
 *     exists.
 * @method int|bool rPushx(string $key, mixed $value) Adds the string value to the tail (right) of the list if the list
 *     exists . FALSE in case of Failure.
 * @method mixed|bool lPop(string $key) Returns and removes the first element of the list.
 * @method mixed|bool rPop(string $key) Returns and removes the last element of the list.
 * @method array blPop(string $key, int $timeout) Is a blocking lPop primitive. If at least one of the lists contains
 *     at least one element, the element will be popped from the head of the list and returned to the caller. Il all
 *     the list identified by the keys passed in arguments are empty, blPop will block during the specified timeout
 *     until an element is pushed to one of those lists. This element will be popped.
 * @method array brPop(string $key, int $timeout) Is a blocking rPop primitive. If at least one of the lists contains
 *     at least one element, the element will be popped from the head of the list and returned to the caller. Il all
 *     the list identified by the keys passed in arguments are empty, brPop will  block during the specified timeout
 *     until an element is pushed to one of those lists. This element will be popped.
 * @method int|bool lLen(string $key) Returns the size of a list identified by Key. If the list didn't exist or is
 *     empty, the command returns 0. If the data type identified by Key is not a list, the command return FALSE.
 * @method int|bool lSize(string $key) The size of the list identified by Key exists
 * @method mixed|bool lIndex(string $key, int $index) Return the specified element of the list stored at the specified
 *     key. 0 the first element, 1 the second ... -1 the last element, -2 the penultimate ... Return FALSE in case of a
 *     bad index or a key that doesn't point to a list.
 * @method  mixed|bool lGet(string $key, int $index)
 * @method  bool lSet(string $key, int $index, mixed $value) Set the list at index with the new value.
 * @method array lRange(string $key, int $start, int $end) Returns the specified elements of the list stored at the
 *     specified key in the range [start, end]. start and stop are interpretated as indices: 0 the first element, 1 the
 *     second ... -1 the last element, -2 the penultimate ...
 * @method array lGetRange(string $key, int $start, int $end)
 * @method array|bool lTrim(string $key, int $start, int $stop) Trims an existing list so that it will contain only a
 *     specified range of elements.
 * @method array|bool listTrim(string $key, int $start, int $stop)
 * @method int|bool lRem(string $key, string $value, int $count) Removes the first count occurences of the value
 *     element from the list. If count is zero, all the matching elements are removed. If count is negative, elements
 *     are removed from tail to head.
 * @method int|bool lRemove(string $key, string $value, int $count)
 * @method int lInsert(string $key, int $position, string $pivot, string|mixed $value) Insert value in the list before
 *     or after the pivot value. the parameter options specify the position of the insert (before or after). If the
 *     list didn't exists, or the pivot didn't exists, the value is not inserted.
 * @method int|bool sAdd(string $key, mixed|string ...$value1) Adds a values to the set value stored at key.
 * @method int sRem(string $key, string|mixed ...$member1) Removes the specified members from the set value stored at
 *     key.
 * @method int sRemove(string $key, string|mixed ...$member1) Removes the specified members from the set value stored
 *     at key.
 * @method bool sMove(string $srcKey, string $dstKey, string|mixed $member) Removes the specified members from the set
 *     value stored at key.
 * @method bool sIsMember(string $key, string|mixed $value) Checks if value is a member of the set stored at the key
 *     key.
 * @method bool sContains(string $key, string|mixed $value) Checks if value is a member of the set stored at the key
 *     key.
 * @method int sCard(string $key) Returns the cardinality of the set identified by key.
 * @method string|mixed|array|bool sPop(string $key, int $count = 1) Removes and returns a random element from the set
 *     value at Key.
 * @method string|mixed|array|bool sRandMember(string $key, int $count = 1) Returns a random element(s) from the set
 *     value at Key, without removing it.value(s) from the set bool FALSE if set identified by key is empty or doesn't
 *     exist and count argument isn't passed.
 * @method array sInter(string $key1, string ...$otherKeys) Returns the members of a set resulting from the
 *     intersection of all the sets held at the specified keys. If just a single key is specified, then this command
 *     produces the members of this set. If one of the keys is missing, FALSE is returned.
 * @method int|bool sInterStore(string $dstKey, string $key1, string ...$otherKeys) Performs a sInter command and
 *     stores the result in a new set.
 * @method string[] sUnion(string $key, string ...$otherKeys) Performs the union between N sets and returns it.
 * @method int sUnionStore(string $dstKey, string $key, string ...$otherKeys) Performs the same action as sUnion, but
 *     stores the result in the first key
 * @method array sDiff(string $key1, string ...$otherKeys) Performs the difference between N sets and returns it.
 * @method int|bool sDiffStore(string $dstKey, string $key1, string ...$otherKeys) Performs the same action as sDiff,
 *     but stores the result in the first key
 * @method array sMembers(string $key) Returns the contents of a set.
 * @method array sGetMembers(string $key) Returns the contents of a set.
 * @method array|bool sScan(string $key, int &$iterator, string $pattern = null, int $count = 0) Scan a set for members
 *      PHPRedis will return an array of keys or FALSE when we're done iterating
 * @method string|mixed getSet(string $key, string|mixed $value) Sets a value and returns the previous entry at that
 *     key. A string (mixed, if used serializer), the previous value located at this key
 * @method string randomKey() Returns a random key
 * @method bool select(int $db) Switches to a given database
 * @method bool move(string $key, int $dbIndex) Moves a key to a different database.
 * @method bool rename(string $srcKey, string $dstKey) Renames a key
 * @method bool renameKey(string $srcKey, string $dstKey) Renames a key
 * @method bool renameNx(string $srcKey, string $dstKey) Same as rename, but will not replace a key if the  destination
 *     already exists. This is the same behaviour as setNx.
 * @method bool expire(string $key, int|DateTimeInterface|CarbonInterface $seconds) Sets an expiration date (a timeout)
 *     on an item
 * @method bool pExpire($key, int|DateTimeInterface|CarbonInterface $milliseconds) Sets an expiration date (a timeout
 *     in milliseconds) on an item
 * @method bool setTimeout(string $key, int|DateTimeInterface|CarbonInterface $seconds) Sets an expiration date (a
 *     timeout) on an item
 * @method bool expireAt(string $key, int|DateTimeInterface|CarbonInterface $timestamp) Sets an expiration date (a
 *     timestamp) on an item.
 * @method bool pExpireAt(string $key, int|DateTimeInterface|CarbonInterface $timestamp) Sets an expiration date (a
 *     timestamp) on an item. Requires a timestamp in milliseconds
 * @method string[] keys(string $pattern) Returns the keys that match a certain pattern.
 * @method string[] getKeys(string $pattern) Returns the keys that match a certain pattern.
 * @method int dbSize()  Returns the current database's size
 * @method bool auth(string $password) Authenticate the connection using a password. Warning: The password is sent in
 *     plain-text over the network.
 * @method bool bgrewriteaof() Starts the background rewrite of AOF (Append-Only File)
 * @method bool slaveof(string $host = '127.0.0.1', int $port = 6379) Changes the slave status
 * @method mixed slowLog(string $operation, int $length = null) Access the Redis slowLog
 * @method string|int|bool object(string $string = '', string $key = '') Describes the object pointed to by a key. The
 *     information to retrieve (string) and the key (string). Info can be one of the following: - "encoding" -
 *     "refcount" - "idletime"
 * @method bool save()  Performs a synchronous save.
 * @method bool bgsave() Performs a background save.
 * @method CarbonInterface lastSave() Returns the timestamp of the last disk save.
 * @method int wait(int $numSlaves, int $timeout) Blocks the current client until all the previous write commands are
 *     successfully transferred and acknowledged by at least the specified number of slaves.
 * @method int type(string $key) Returns the type of data pointed by a given key.
 * @method int append(string $key, string|mixed $value) Append specified string to the string stored in specified key.
 * @method string getRange(string $key, int $start, int $end) Return a substring of a larger string
 * @method string setRange(string $key, int $offset, string $value) Changes a substring of a larger string.
 * @method int strlen(string $key) Get the length of a string value.
 * @method int bitpos(string $key, int $bit, int $start = 0, ?int $end = null) Return the position of the first bit set
 *     to 1 or 0 in a string. The position is returned, thinking of the string as an array of bits from left to right,
 *     where the first byte's most significant bit is at position 0, the second byte's most significant bit is at
 *     position 8, and so forth. The command returns the position of the first bit set to 1 or 0 according to the
 *     request. If we look for set bits (the bit argument is 1) and the string is empty or composed of just zero bytes,
 *     -1 is returned. If we look for clear bits (the bit argument is 0) and the string only contains bit set to 1, the
 *     function returns the first bit not part of the string on the right. So if the string is three bytes set to the
 *     value 0xff the command BITPOS key 0 will return 24, since up to bit 23 all the bits are 1. Basically, the
 *     function considers the right of the string as padded with zeros if you look for clear bits and specify no range
 *     or the start argument only. However, this behavior changes if you are looking for clear bits and specify a range
 *     with both start and end. If no clear bit is found in the specified range, the function returns -1 as the user
 *     specified a clear range and there are no 0 bits in that range.
 * @method int getBit(string $key, int $offset) Return a single bit out of a larger string
 * @method int setBit(string $key, int $offset, bool|int $value) Changes a single bit of a string.
 * @method int bitCount(string $key) Count bits in a string, The number of bits set to 1 in the value behind the input
 *     key
 * @method int bitOp(string $operation, string $retKey, string $key1, string ...$otherKeys) Bitwise operation on
 *     multiple keys.
 * @method bool flushDB() Removes all entries from the current database.
 * @method bool flushAll() Removes all entries from all databases.
 * @method array sort(string $key, array $option)  optional, with the following keys and values: - 'by' =>
 *     'some_pattern_*', - 'limit' => array(0, 1), - 'get' => 'some_other_pattern_*' or an array of patterns, - 'sort'
 *     => 'asc' or 'desc', - 'alpha' => TRUE, - 'store' => 'external-key', Returns an array of values, or a number
 *     corresponding to the number of elements stored if that was used
 * @method int|bool ttl(string $key) Returns the time to live left for a given key, in seconds. If the key doesn't
 *     exist, FALSE is returned.
 * @method int|bool pttl(string $key) Returns a time to live left for a given key, in milliseconds. If the key doesn't
 *     exist, FALSE is returned.
 * @method bool persist(string $key) Remove the expiration timer from a key. TRUE if a timeout was removed, FALSE if
 *     the key didn’t exist or didn’t have an expiration timer.
 * @method bool mset(array $array) Sets multiple key-value pairs in one atomic command. MSETNX only returns TRUE if all
 *     the keys were set (see SETNX).
 * @method bool msetnx(array $array) Sets multiple key-value pairs in one atomic command. MSETNX only returns TRUE if
 *     all the keys were set (see SETNX).
 * @method array getMultiple(array $keys) Get the values of all the specified keys. If one or more keys dont exist, the
 *     array will contain FALSE at the position of the key.
 * @method array  mget(array $array) For every key that does not hold a string value or does not exist, the special
 *     value false is returned. Because of this, the operation never fails.
 * @method string|mixed|bool rpoplpush(string $srcKey, string $dstKey) Pops a value from the tail of a list, and pushes
 *     it to the front of another list. Also return this value.
 * @method string|mixed|bool brpoplpush(string $srcKey, string $dstKey, int $timeout)  A blocking version of rpoplpush,
 *     with an integral timeout in the third parameter.
 * @method array zAdd(string $key, array  $options, float $score1, string|mixed $value1, ?float $score2 = null,  string|mixed|null $value2 = null, ?float $scoreN = null,string|mixed|null $valueN = null)
 */
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
    public function __construct(string $host, ?int $port = null, int $database = 1, string $prefix = 'app:')
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
