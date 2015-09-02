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

            if($this->model->authenticateLogin($this->view->getUsername(), $this->view->getPassword())){
                $this->model->loginUser($this->view->getClientIdentifier());
                $this->view->setLoginMessage();
                $this->view->reloadPage();
            }

        }elseif($this->view->userPressedLogout()){
            $this->model->logoutUser();
            $this->view->setLogoutMessage();
            $this->view->reloadPage();
        }

        if($ret->authenticated = $this->model->isLoggedIn($this->view->getClientIdentifier())){
            $ret->body = $this->view->generateLogoutForm();

        }else{
            $ret->body = $this->view->generateLoginForm();
        }

        return $ret;
    }
}