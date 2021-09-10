<?php

return [
    'routes' => [
        '/'           => 'App\Controller\IndexController@indexAction',
        '/404'        => 'App\Controller\ErrorController@notFoundAction',
        '/statistics' => 'App\Controller\StatisticsController@indexAction',
    ],
];
