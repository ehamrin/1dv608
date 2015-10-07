<?php
session_name("PHPSESSID");
session_start();

require_once 'common/Exception.php';
require_once 'Settings.php';

spl_autoload_register(function ($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);

    //MVC structure
    $filename = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $class . '.php';
    //Common folder
    $common = __DIR__ . DIRECTORY_SEPARATOR . 'common' . DIRECTORY_SEPARATOR . array_pop(explode(DIRECTORY_SEPARATOR, $class)) . '.php';

    if(file_exists($filename)){
        require_once $filename;
    }elseif(file_exists($common)){
        require_once $common;
    }
});

define("STRICT_TYPING", 0);

define("APPLICATION_URL", "http://" . $_SERVER['HTTP_HOST'] . "/4/");
define("APPLICATION_URI", getcwd() . '/');