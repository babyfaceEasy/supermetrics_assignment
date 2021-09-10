<?php

namespace SocialPost\Service\Factory;

use SocialPost\Driver\Factory\FictionalDriverFactory;
use SocialPost\Hydrator\FictionalPostHydrator;
use SocialPost\Service\SocialPostService;

/**
 * Class SocialPostServiceFactory
 *
 * @package SocialPost\Service\Factory
 */
class SocialPostServiceFactory
{

    /**
     * @return SocialPostService
     */
    public static function create(): SocialPostService
    {
        $driver = FictionalDriverFactory::create();

        $hydrator = new FictionalPostHydrator();

        return new SocialPostService($driver, $hydrator);
    }
}
