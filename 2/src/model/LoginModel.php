<?php
declare(strict_types=STRICT_TYPING);

namespace model;


class LoginModel
{
    //User credentials
    private static $username = "Admin";
    private static $password = "Password";


    private $dal;

    public function __construct(){
        $this->dal = new dal\LoginDAL("");
    }

    public function IsLoggedIn(\string $clientIdentifier) : \bool
    {
        return ($this->dal->Get() === $clientIdentifier);
    }

    public function AuthenticateLogin(\model\UserCredentials $credentials) : \bool
    {
        return $credentials->GetUsername() === self::$username && $credentials->GetPassword() === self::$password || dal\PersistentLoginDAL::MatchRecord($credentials);
    }

    public function GetPersistentLogin(\string $user) : PersistentLoginModel
    {
        return new PersistentLoginModel($user);
    }

    public function LoginUser(\string $clientIdentifier)
    {
        $this->dal->Save($clientIdentifier);
    }

    public function LogoutUser()
    {
        $this->dal->Remove();
    }

}