<?php

namespace controller;

class LoginController
{
    private $model;
    private $view;

    public function __construct(){
        $this->model = new \model\LoginModel();
        $this->view = new \view\LoginView($this->model);
    }

    public function AuthenticateUser(){
        $ret = new \model\ContentModel();

        if($this->model->IsLoggedIn($this->view->GetClientIdentifier()) == FALSE){
            if($this->view->UserAttemptedLogin()){

                if($this->model->AuthenticateLogin($this->view->GetUserCredentials())){
                    $this->model->LoginUser($this->view->GetClientIdentifier());
                    $this->view->LoginSuccess();
                }else{
                    $this->view->LoginFailed();
                }
            }
        }else{
            if($this->view->UserPressedLogout()){
                $this->model->LogoutUser();
                $this->view->LogoutUser();
            }
        }

        $ret->body = $this->view->GetForm();

        return $ret;
    }

}