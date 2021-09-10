<?php

namespace SocialPost\Cache\Factory;

use Memcached;
use Psr\SimpleCache\CacheInterface;
use SebastianBergmann\Timer\RuntimeException;
use Symfony\Component\Cache\Simple\MemcachedCache;

/**
 * Class CacheFactory
 *
 * @package SocialPost\Cache\Factory
 */
class CacheFactory
{

    /**
     * @return CacheInterface
     */
    public static function create(): CacheInterface
    {
        $client = static::getClient();

        $host = $_ENV['MEMCACHED_HOST'];
        $port = $_ENV['MEMCACHED_PORT'];
        $client->addServer($host, $port);

        if (false === $client->getStats()) {
            throw new RuntimeException('Cache is offline');
        }

        return new MemcachedCache($client);
    }

    /**
     * @return Memcached
     */
    protected static function getClient(): Memcached
    {
        return new Memcached();
    }
}
