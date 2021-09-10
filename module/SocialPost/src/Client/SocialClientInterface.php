<?php

namespace SocialPost\Client;

/**
 * Class SocialApiClientInterface
 *
 * @package SocialPost\Client
 */
interface SocialClientInterface
{

    /**
     * @param string $url
     * @param array  $parameters
     *
     * @return string
     */
    public function get(string $url, array $parameters): string;

    /**
     * @param string $url
     * @param array  $body
     *
     * @return string
     */
    public function post(string $url, array $body): string;

    /**
     * @param string $url
     * @param array  $body
     *
     * @return string
     */
    public function authRequest(string $url, array $body): string;
}
