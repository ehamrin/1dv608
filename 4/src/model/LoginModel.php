<?php
declare(strict_types=STRICT_TYPING);

namespace model;


class LoginModel
{
    private $dal;
    private $userDal;

    public function __construct(){
        $this->dal = new dal\LoginDAL();
        $this->userDal = new dal\UserDAL();
    }

    public function IsLoggedIn(\string $clientIdentifier) : \bool
    {
        $uc = $this->dal->Get();
        if($uc != null){
            $uc = unserialize($uc);
            return ($uc->GetUniqueClientIdentifier() === $clientIdentifier);
        }
        return false;
    }
    public function AuthenticateLogin(\model\UserCredentials $credentials) : \bool
    {
        foreach($this->userDal->GetAllUsers() as $entry){
            /* @var $entry \model\UserCredentials */
            if($entry->GetUsername() == $credentials->GetUsername() && password_verify($credentials->GetPassword(), $entry->GetPassword())){
                $this->LoginUser($credentials);
                return true;
            }
        }

        if(dal\PersistentLoginDAL::MatchRecord($credentials)){
            $this->LoginUser($credentials);
            return true;
        }

        return false;
    }

    public function GetPersistentLogin(\string $user) : PersistentLoginModel
    {
        return new PersistentLoginModel($user);
    }

    public function LoginUser(\model\UserCredentials $credentials)
    {
        $this->dal->Save(serialize($credentials));
    }

    public function LogoutUser()
    {
        $this->dal->Remove();
    }

    public function UserExists(UserCredentials $uc){
        foreach($this->userDal->GetAllUsers() as $entry){
            /* @var $entry \model\UserCredentials */
            if($entry->GetUsername() == $uc->GetUsername()) {

                return true;
            }
        }
        return false;
    }

    public function RegisterUser(UserCredentials $uc) : \bool
    {
        foreach($this->userDal->GetAllUsers() as $entry){
            /* @var $entry \model\UserCredentials */
            if($entry->GetUsername() == $uc->GetUsername()) {

                return false;
            }
        }

        $this->userDal->Add($uc);

        return true;
    }

}