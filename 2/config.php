<?php
session_name("PHPSESSID");
//session_set_cookie_params(0, '/2/', '1dv608.erikhamrin.se');
session_start();

spl_autoload_register(function ($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $filename = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $class . '.php';
    if(file_exists($filename)){
        require_once $filename;
    }
});

define("APPLICATION_URL", "http://" . $_SERVER['HTTP_HOST'] . "/2/");
define("APPLICATION_URI", "/var/www/1dv608.erikhamrin.se/2/");
define("LOG_FILE_DIR", APPLICATION_URI . "log/");