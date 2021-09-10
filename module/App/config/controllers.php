<?php

use App\Controller\ErrorController;
use App\Controller\Factory\StatisticsControllerFactory;
use App\Controller\IndexController;
use App\Controller\StatisticsController;

return [
    'controllers' => [
        'invokables' => [
            IndexController::class,
            ErrorController::class,
        ],
        'factories'  => [
            StatisticsController::class => StatisticsControllerFactory::class,
        ],
    ],
];