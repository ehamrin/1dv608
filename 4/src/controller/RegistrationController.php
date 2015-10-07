<?php


namespace controller;


class RegistrationController
{
    private $view;
    private $navigationView;
    private $model;

    public function __construct(\view\NavigationView $nv, \view\RegistrationView $rv, \model\RegistrationModel $model){
        $this->navigationView = $nv;
        $this->view = $rv;
        $this->model = $model;
    }

    public function doRegister() : \bool
    {
        if($this->view->UserSubmittedRegistration()){
            if($this->model->RegisterUser($this->view->GetUserCredentials())){
                $this->view->RegistrationSuccess();
            }
        }
        return false;
    }

    public function GetView() : \string
    {
        return $this->view->GetView();
    }

}