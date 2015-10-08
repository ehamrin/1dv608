<?php


namespace model;


class RegistrationModel
{
    private $userDal;

    public function __construct(\model\dal\UserDAL $userDAL){
        $this->userDal = $userDAL;
    }

    public function RegisterUser(UserCredentials $uc) : \bool
    {
        if($this->UserExists($uc)){
            return false;
        }

        $this->userDal->Add($uc);

        return true;
    }

    public function UserExists(UserCredentials $uc){
        return $this->userDal->UserExists($uc);
    }

}