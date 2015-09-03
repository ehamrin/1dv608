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
                $this->LogoutUser();
                $this->view->ReloadPage();

            }
        }else{
            //Cases to allow when user is logged out
            if($this->view->UserAttemptedLogin() && $this->view->FormIsCorrect()){

                if($this->model->AuthenticateLogin($this->view->GetUsername(), $this->view->GetPassword())){
                    $this->model->LoginUser($this->view->GetClientIdentifier());

                    if($this->view->KeepUserLoggedIn()){

                        $this->persistent_login_view->storeLogin($this->model->GeneratePersistentLogin($this->view->GetUsername()));

                        $this->view->SetPersistentLoginMessage();
                    }else{
                        $this->view->SetLoginMessage();
                    }

                    $this->view->ReloadPage();
                }

            }elseif($this->persistent_login_view->userHasPersistentLogin()){

                if($this->model->AuthenticatePersistentLogin($this->persistent_login_view->getCookieUsername(), $this->persistent_login_view->getCookieSecurityString())){
                    $this->model->LoginUser($this->view->GetClientIdentifier());
                    $this->view->SetWelcomeBackMessage();

                }else{

                    $this->LogoutUser();
                    $this->view->SetWrongCookieMessage();
                }

                $this->view->ReloadPage();

            }
        }

        if($ret->authenticated = $this->model->IsLoggedIn($this->view->GetClientIdentifier())){
            $ret->body = $this->view->GenerateLogoutForm();

        }else{
            $ret->body = $this->view->GenerateLoginForm();
        }

        return $ret;
    }

    private function LogoutUser(){
        $this->model->LogoutUser();
        $this->persistent_login_view->removePersistentLogin();
        $this->view->SetLogoutMessage();
    }
}