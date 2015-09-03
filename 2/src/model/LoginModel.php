<?php


namespace model;


class LoginModel
{
    //User credentials
    private static $username = "Admin";
    private static $password = "Password";


    private static $sessionLocation = "\\Model\\LoginView::Logged_In";

    private $p_dal;

    public function __construct(){
        $this->p_dal = new dal\PersistentLoginDAL();
    }

    public function IsLoggedIn($clientIdentifier)
    {
        if(isset($_SESSION[self::$sessionLocation]) && $_SESSION[self::$sessionLocation] === $clientIdentifier){
            return true;
        }

        return false;

    }

    public function AuthenticateLogin(\model\UserCredentials $credentials){

        return $credentials->GetUsername() === self::$username && $credentials->GetPassword() === self::$password || $this->p_dal->MatchRecord($credentials->GetUsername(), $credentials->GetPassword());
    }

    public function GetPersistentLogin($user){

        $login = new PersistentLoginModel($user);

        $this->p_dal->Log($login);

        return $login;
    }

    public function MatchPersistentLogin($user, $passPhrase){

        return $this->p_dal->MatchRecord($user, $passPhrase);
    }

    public function LoginUser($clientIdentifier){
        $_SESSION[self::$sessionLocation] = $clientIdentifier;
    }

    public function LogoutUser(){
        unset($_SESSION[self::$sessionLocation]);
    }

}