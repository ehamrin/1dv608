<?php
declare(strict_types=STRICT_TYPING);

namespace controller;

class LoginController
{
    private $model;
    private $view;
    private $navigationView;

    public function __construct(\view\NavigationView $nv, \model\LoginModel $model, \view\LoginView $lv){
        $this->model = $model;
        $this->navigationView = $nv;
        $this->view = $lv;
    }

    public function DoLogin(&$authenticated)
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

        $authenticated = $this->model->IsLoggedIn($this->view->GetClientIdentifier());
    }

    public function GetView(){
        return $this->view->GetView();
    }
}