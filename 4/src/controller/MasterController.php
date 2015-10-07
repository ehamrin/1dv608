<?php


namespace controller;


class MasterController
{

    private $navigationView;
    private $view;
    private $registerView;

    public function __construct()
    {
        $userDAL = new \model\dal\UserDAL();
        $this->loginModel = new \model\LoginModel($userDAL);
        $this->registerModel = new \model\RegistrationModel($userDAL);

        $this->navigationView = new \view\NavigationView();
        $this->lv = new \view\LoginView($this->loginModel, $this->navigationView);
        $this->registerView = new \view\RegistrationView($this->registerModel, $this->navigationView);
    }

    public function handleInput() {

        $login = new LoginController($this->navigationView, $this->loginModel, $this->lv);
        $registration = new RegistrationController($this->navigationView, $this->registerView, $this->registerModel);

        $authenticated = false;

        if ($this->navigationView->inRegistration() ) {
            if($registration->doRegister()){
                $authenticated = $login->DoLogin();
                $this->view = $login->GetView();
            }else{
                $this->view = $registration->GetView();
            }
        } else {
            $authenticated = $login->DoLogin();
            $this->view = $login->GetView();
        }

        return $authenticated;
    }

    public function generateOutput() {
        return $this->view;
    }
}