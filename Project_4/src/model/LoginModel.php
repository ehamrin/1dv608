<?php
declare(strict_types=STRICT_TYPING);

namespace model;


class LoginModel
{
    private $dal;
    private $userDal;

    public function __construct(\model\dal\UserDAL $userDAL, dal\PersistentLoginDAL $pld){
        $this->dal = new dal\LoginDAL();
        $this->persistentLoginDAL = $pld;
        $this->userDal = $userDAL;
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

        if($this->persistentLoginDAL->MatchRecord($credentials)){
            $this->LoginUser($credentials);
            return true;
        }

        return false;
    }

    public function GetPersistentLogin(\string $user) : PersistentLogin
    {
        return new PersistentLogin($user, $this->persistentLoginDAL);
    }

    public function LoginUser(\model\UserCredentials $credentials)
    {
        $this->dal->Save(serialize($credentials));
    }

    public function LogoutUser()
    {
        $this->dal->Remove();
    }

}