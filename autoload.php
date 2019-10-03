<?php
if (session_id() === "") {
    session_start();
}

require_once 'config/api.php';

// doesn't work on linux because of namespace format (core\Router -> core/Router)
//spl_autoload_extensions('.php');
//spl_autoload_register(function($class) {
//    return spl_autoload($class);
//});

spl_autoload_extensions(".php");
spl_autoload_register(function($class) {
    include_once __DIR__ . '/' . str_replace("\\", "/", $class) . '.php';
});
