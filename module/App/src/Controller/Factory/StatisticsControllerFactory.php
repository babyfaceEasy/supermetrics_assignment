<?php

namespace App\Controller\Factory;

use App\Controller\ControllerInterface;
use App\Controller\StatisticsController;
use SocialPost\Service\Factory\SocialPostServiceFactory;
use Statistics\Extractor\StatisticsToExtractor;
use Statistics\Service\Factory\StatisticsServiceFactory;

/**
 * Class StatisticsControllerFactory
 *
 * @package App\Controller\Factory
 */
class StatisticsControllerFactory implements ControllerFactoryInterface
{

    /**
     * @return ControllerInterface
     */
    public function create(): ControllerInterface
    {
        $statsService = StatisticsServiceFactory::create();

        $socialService = SocialPostServiceFactory::create();

        return new StatisticsController($statsService, $socialService, new StatisticsToExtractor());
    }
}
