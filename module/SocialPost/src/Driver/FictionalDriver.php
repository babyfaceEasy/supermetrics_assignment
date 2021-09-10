<?php

namespace SocialPost\Driver;

use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;
use SocialPost\Client\SocialClientInterface;
use SocialPost\Exception\BadResponseException;
use SocialPost\Exception\InvalidTokenException;
use Traversable;

/**
 * Class FictionalSocialApiDriver
 *
 * @package SocialPost\Driver
 */
class FictionalDriver implements SocialDriverInterface
{

    private const REGISTER_TOKEN_URI = '/assignment/register';

    private const FETCH_POSTS_URI = '/assignment/posts';

    private const TOKEN_CACHE_KEY = 'fictional-access-token';

    private const TOKEN_CACHE_TTL = 60 * 59; // a bit less than an hour

    /**
     * @var SocialClientInterface
     */
    private $client;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * FictionalSocialApiDriver constructor.
     *
     * @param SocialClientInterface $client
     */
    public function __construct(
        SocialClientInterface $client
    ) {
        $this->client = $client;
    }

    /**
     * @param CacheInterface|null $cache
     *
     * @return $this
     */
    public function setCache(?CacheInterface $cache): self
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @param int $page
     *
     * @return Traversable
     * @throws InvalidArgumentException
     */
    public function fetchPostsByPage(int $page): Traversable
    {
        $token = $this->getAccessToken();

        try {
            $response = $this->retrievePage($page, $token);
        } catch (InvalidTokenException $exception) {
            // Token was rejected, give it another try with a new one
            $this->invalidateCachedToken();
            $token    = $this->getAccessToken();
            $response = $this->retrievePage($page, $token);
        }

        yield from $this->extractPosts($response);
    }

    /**
     * @param array $responseData
     *
     * @return array
     */
    protected function extractPosts(array $responseData): array
    {
        $posts = $responseData['data']['posts'] ?? null;

        if (null === $posts) {
            throw new BadResponseException('No posts returned');
        }

        return $posts;
    }

    /**
     * @param int    $page
     * @param string $token
     *
     * @return array
     */
    protected function retrievePage(int $page, string $token): array
    {
        $response = $this->client->get(
            self::FETCH_POSTS_URI,
            [
                'page'     => $page,
                'sl_token' => $token,
            ]
        );

        return \GuzzleHttp\json_decode($response, true);
    }

    /**
     * @return string
     * @throws InvalidArgumentException
     */
    protected function registerToken(): string
    {
        //Todo: retrieve current user data from  an auth service stub
        $userData = [
            'email' => 'your@email.address',
            'name'  => 'YourName',
        ];

        $response = $this->client->authRequest(self::REGISTER_TOKEN_URI, $userData);
        $response = \GuzzleHttp\json_decode($response, true);

        $token = $response['data']['sl_token'] ?? null;
        if (null === $token) {
            throw new BadResponseException('No access token returned');
        }

        if (null !== $this->cache) {
            $this->cache->set(self::TOKEN_CACHE_KEY, $token, self::TOKEN_CACHE_TTL);
        }

        return $token;
    }

    /**
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getAccessToken(): string
    {
        $token = null;
        if (null !== $this->cache) {
            $token = $this->cache->get(self::TOKEN_CACHE_KEY);
        }

        if (null === $token) {
            $token = $this->registerToken();
        }

        return $token;
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function invalidateCachedToken(): void
    {
        if (null === $this->cache) {
            return;
        }

        $this->cache->delete(self::TOKEN_CACHE_KEY);
    }
}
