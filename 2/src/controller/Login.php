<?php


namespace controller;


class Login
{
    private $model;
    private $view;

    public function __construct(){
        $this->model = new \model\Login();
        $this->view = new \view\Login($this->model());
    }

    public function AuthenticateUser(){
        return "It works!";
    }
}