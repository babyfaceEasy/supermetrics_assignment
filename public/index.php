<?php

use App\Dispatcher\RouteDispatcher;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

$dotEnv = Dotenv::createImmutable(__DIR__ . '/..');
$dotEnv->load();

\App\Config\Config::init();

$requestUri = $_SERVER['REQUEST_URI'];

RouteDispatcher::dispatch($requestUri);