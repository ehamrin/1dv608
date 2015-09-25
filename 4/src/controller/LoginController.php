<?php
declare(strict_types=STRICT_TYPING);

namespace controller;

class LoginController
{
    private $model;
    private $view;

    public function __construct(){
        $this->model = new \model\LoginModel();
        $this->view = new \view\LoginView($this->model);
    }

    public function AuthenticateUser() : \model\ContentModel
    {

        if($this->model->IsLoggedIn($this->view->GetClientIdentifier()) == FALSE){
            if($this->view->UserAttemptedLogin()){

                if($this->model->AuthenticateLogin($this->view->GetUserCredentials())){
                    $this->view->LoginSuccess();
                }else{
                    $this->view->LoginFailed();
                }
            }
        }else{
            if($this->view->UserAttemptedLogout()){
                $this->model->LogoutUser();
                $this->view->LogoutUser();
            }
        }

        return new \model\ContentModel($this->view->GetForm(), $this->model->IsLoggedIn($this->view->GetClientIdentifier()));
    }
}