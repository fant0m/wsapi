<?php
use core\Autowire;
use core\Router;

include 'autoload.php';
include 'routes.php';

$autowire = Autowire::getInstance();
$autowire->set('core\HttpClient', 'core\Curl');

$router = Router::getInstance();
echo $router->dispatch();
