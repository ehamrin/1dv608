<?php


namespace controller;


class Login
{
    private $model;
    private $view;

    public function __construct(){
        $this->model = new \model\Login();
        $this->view = new \view\Login($this->model);
    }

    public function AuthenticateUser(){
        $ret = new \model\HTMLPage();

        if($this->view->userAttemptedLogin() && $this->view->formIsCorrect()){
            $this->model->authenticateLogin($this->view->getUsername(), $this->view->getPassword());
            //TODO Check for valid authentication data
        }

        if($this->model->isLoggedIn()){
            $ret->body = $this->view->showLogout();
        }else{
            $ret->body = $this->view->showForm();
        }



        return $ret;
    }
}