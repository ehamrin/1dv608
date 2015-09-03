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
        $ret = new \model\HTMLPageModel();

        if($this->model->isLoggedIn($this->view->getClientIdentifier())){
            //Cases to allow when user is logged in
            if($this->view->userPressedLogout()){
                $this->logoutUser();
                $this->view->reloadPage();

            }
        }else{
            //Cases to allow when user is logged out
            if($this->view->userAttemptedLogin() && $this->view->formIsCorrect()){

                if($this->model->authenticateLogin($this->view->getUsername(), $this->view->getPassword())){
                    $this->model->loginUser($this->view->getClientIdentifier());

                    if($this->view->keepUserLoggedIn()){

                        $this->view->storeLogin($this->model->generatePersistentLogin($this->view->getUsername()));

                        $this->view->setPersistentLoginMessage();
                    }else{
                        $this->view->setLoginMessage();
                    }

                    $this->view->reloadPage();
                }

            }elseif($this->view->userHasPersistentLogin()){

                if($this->model->authenticatePersistentLogin($this->view->getCookieUsername(), $this->view->getCookieSecurityString())){
                    $this->model->loginUser($this->view->getClientIdentifier());
                    $this->view->setWelcomeBackMessage();

                }else{

                    $this->logoutUser();
                    $this->view->setWrongCookieMessage();
                }

                $this->view->reloadPage();

            }
        }

        if($ret->authenticated = $this->model->isLoggedIn($this->view->getClientIdentifier())){
            $ret->body = $this->view->generateLogoutForm();

        }else{
            $ret->body = $this->view->generateLoginForm();
        }

        return $ret;
    }

    private function logoutUser(){
        $this->model->logoutUser();
        $this->view->removePersistentLogin();
        $this->view->setLogoutMessage();
    }
}