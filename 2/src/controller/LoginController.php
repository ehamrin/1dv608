<?php

namespace controller;

class LoginController
{
    private $model;
    private $view;
    private $persistent_login_view;

    public function __construct(){
        $this->model = new \model\LoginModel();
        $this->view = new \view\LoginView($this->model);
        $this->persistent_login_view = new \view\PersistentLoginView();
    }

    public function AuthenticateUser(){
        $ret = new \model\HTMLPageModel();

        if($this->model->IsLoggedIn($this->view->GetClientIdentifier())){
            //Cases to allow when user is logged in
            if($this->view->UserPressedLogout()){
                $this->model->LogoutUser();
                $this->view->LogoutUser();
            }
        }else{
            //Cases to allow when user is logged out
            if($this->view->UserAttemptedLogin()){

                if($this->model->AuthenticateLogin($this->view->GetUserCredentials())){
                    $this->model->LoginUser($this->view->GetClientIdentifier());
                    $this->view->LoginSuccess();
                }else{
                    $this->view->LoginFailed();
                }

            }
        }

        $ret->body = $this->view->GetForm();

        return $ret;
    }

}