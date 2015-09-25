<?php
declare(strict_types=STRICT_TYPING);

namespace controller;

class LoginController
{
    private $model;
    private $lv;
    private $nv;
    private $rv;

    public function __construct(){
        $this->model = new \model\LoginModel();
        $this->nv = new \view\NavigationView();
        $this->lv = new \view\LoginView($this->model, $this->nv);
        $this->rv = new \view\RegistrationView($this->model, $this->nv);
    }

    public function DoControl() : \model\ContentModel
    {
        $ret = "";

        if($this->model->IsLoggedIn($this->lv->GetClientIdentifier()) == FALSE){
            if($this->lv->UserAttemptedLogin()){
                $ret = $this->AuthenticateUser();

            }elseif($this->nv->UserNavigatesToRegistration()){
                if($this->rv->UserAttemptedRegistration()){
                    $ret = $this->RegisterUser();
                }else{
                    $ret = $this->rv->GetForm();
                }
            }else{
                $ret = $this->lv->GetForm();
            }

        }else{
            if($this->lv->UserAttemptedLogout()){
                $this->LogoutUser();
            }

            $ret = $this->lv->GetForm();
        }

        return new \model\ContentModel($ret, $this->model->IsLoggedIn($this->lv->GetClientIdentifier()));
    }

    private function AuthenticateUser(){
        if($this->model->AuthenticateLogin($this->lv->GetUserCredentials())){
            $this->lv->LoginSuccess();
        }else{
            $this->lv->LoginFailed();
        }

        return $this->lv->GetForm();
    }

    private function LogoutUser(){
        $this->model->LogoutUser();
        $this->lv->LogoutUser();
    }

    private function RegisterUser(){
       if($this->model->RegisterUser($this->rv->GetUserCredentials())){
            $this->lv->RegistrationSuccess($this->rv->GetUserCredentials());
            return $this->lv->GetForm();
       }

       return $this->rv->GetForm();
    }
}