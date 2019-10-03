<?php
use core\Route;
use core\Router;

$router = Router::getInstance();

$router->get(Route::ACTION_DEFAULT, 'HomeController', 'welcome');
$router->get(Route::ACTION_NOT_FOUND, 'HomeController', 'notFound');

$router->get('zones', 'ZonesController', 'index');
$router->get('zone_view', 'ZonesController', 'detail');
$router->get('record_new', 'ZonesController', 'newRecord');
$router->post('record_new', 'ZonesController', 'newRecord');
$router->get( 'record_delete', 'ZonesController', 'deleteRecord');
