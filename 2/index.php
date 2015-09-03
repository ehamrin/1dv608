<?php
session_name("PHPSESSID-1dv608-Assignment2");
session_start();

spl_autoload_register(function ($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $filename = __DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $class . '.php';
    if(file_exists($filename)){
        require_once $filename;
    }
});

define("APPLICATION_URL", "http://1dv608.erikhamrin.se/2/");
define("APPLICATION_URI", "/var/www/1dv608.erikhamrin.se/2/");
define("LOG_FILE_DIR", APPLICATION_URI . "log/");

$controller = new \controller\LoginController();
$output = $controller->AuthenticateUser();

$page = new \view\HTMLPageTemplateView();
$page->Render($output);