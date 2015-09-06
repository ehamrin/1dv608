<?php
declare(strict_types=1);
require_once 'config.php';

$controller = new \controller\LoginController();
$output = $controller->AuthenticateUser();

$page = new \view\ContentView();
echo $page->Render($output);