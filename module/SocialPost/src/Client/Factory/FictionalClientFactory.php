<?php

namespace SocialPost\Client\Factory;

use GuzzleHttp\Client;
use SocialPost\Cache\Factory\CacheFactory;
use SocialPost\Client\FictionalClient;
use SocialPost\Client\SocialClientCacheDecorator;
use SocialPost\Client\SocialClientInterface;

/**
 * Class FictionalClientFactory
 *
 * @package SocialPost\Client\Factory
 */
class FictionalClientFactory
{

    private const FICTIONAL_CACHE_KEY = 'fictional';

    /**
     * @return SocialClientInterface
     */
    public static function create(): SocialClientInterface
    {
        $guzzleClient = static::getClient();

        $fallbackClient = new FictionalClient(
            $guzzleClient,
            $_ENV['FICTIONAL_SOCIAL_API_CLIENT_ID']
        );

        try {
            // Try to use a cache to avoid API calls limit exceeding, if there is such
            $cache = CacheFactory::create();
        } catch (\Throwable $throwable) {
            //Cache not ready :(
            $cache = null;
        }

        return null === $cache
            ? $fallbackClient
            : new SocialClientCacheDecorator($fallbackClient, $cache, self::FICTIONAL_CACHE_KEY);
    }

    /**
     * @return Client
     */
    protected static function getClient(): Client
    {
        return new Client(
            [
                'base_uri' => $_ENV['FICTIONAL_SOCIAL_API_HOST'],
            ]
        );
    }
}
