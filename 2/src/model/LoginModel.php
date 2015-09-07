<?php
declare(strict_types=1);

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

    public function IsLoggedIn(\string $clientIdentifier) : \bool
    {
        if(isset($_SESSION[self::$sessionLocation]) && $_SESSION[self::$sessionLocation] === $clientIdentifier){
            return true;
        }

        return false;

    }

    public function AuthenticateLogin(\model\UserCredentials $credentials) : \bool
    {

        return $credentials->GetUsername() === self::$username && $credentials->GetPassword() === self::$password || $this->p_dal->MatchRecord($credentials);
    }

    public function GetPersistentLogin(\string $user) : PersistentLoginModel
    {

        $login = new PersistentLoginModel($user);

        $this->p_dal->Log($login);

        return $login;
    }

    public function LoginUser(\string $clientIdentifier)
    {
        $_SESSION[self::$sessionLocation] = $clientIdentifier;
    }

    public function LogoutUser()
    {
        unset($_SESSION[self::$sessionLocation]);
    }

}