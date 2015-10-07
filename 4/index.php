<?php
require_once 'config.php';

$controller = new \controller\MasterController();
$loggedIn = false;
$controller->handleInput($loggedIn);

$page = new \view\ContentView();
echo $page->Render($controller->generateOutput(), $loggedIn);
