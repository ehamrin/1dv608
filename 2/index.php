<?php
require_once 'config.php';

$controller = new \controller\LoginController();
$output = $controller->AuthenticateUser();

$page = new \view\HTMLPageTemplateView();
$page->Render($output);