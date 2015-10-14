<?php


namespace controller;

class MasterController
{

    private $navigationView;
    private $view;
    private $registrationView;
    private $loginView;

    private $loginModel;
    private $registrationModel;

    public function __construct()
    {
        $db = new \model\dal\Database(\Settings::DB_DSN, \Settings::DB_Database, \Settings::DB_User, \Settings::DB_Password);
        $connection = $db->Establish();

        $persistentDAL = new \model\dal\PersistentLoginDAL($connection);
        $userDAL = new \model\dal\UserDAL($connection);

        $this->loginModel = new \model\LoginModel($userDAL, $persistentDAL);
        $this->registrationModel = new \model\RegistrationModel($userDAL);

        $this->navigationView = new \view\NavigationView();
        $this->loginView = new \view\LoginView($this->loginModel, $this->navigationView);
        $this->registrationView = new \view\RegistrationView($this->registrationModel, $this->navigationView);
    }

    public function handleInput() {
        if ($this->navigationView->inRegistration() ) {
            $registration = new RegistrationController($this->navigationView, $this->registrationView, $this->registrationModel);
            if(!$registration->DoRegister()){
                $this->view = $registration->GetView();
            }
        } else {
            $login = new LoginController($this->navigationView, $this->loginModel, $this->loginView);
            $login->DoLogin();
            $this->view = $login->GetView();
        }
    }

    public function generateOutput() {
        return $this->view;
    }

    //Facade function to avoid unnescessary return values
    public function IsLoggedIn() : \bool
    {
        return $this->loginModel->IsLoggedIn($this->loginView->GetClientIdentifier());
    }
}