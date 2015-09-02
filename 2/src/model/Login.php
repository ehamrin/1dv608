<?php


namespace model;


class Login
{
    //User credentials
    private static $username = "Admin";
    private static $password = "Password";


    private static $sessionLocation = "\\Model\\Login::Logged_In";

    public function isLoggedIn($clientIdentifier)
    {
        if(isset($_SESSION[self::$sessionLocation]) && $_SESSION[self::$sessionLocation] === $clientIdentifier){
            return true;
        }

        return false;

    }

    public function authenticateLogin($username, $password){

        return $username === self::$username && $password === self::$password;
    }

    public function loginUser($clientIdentifier){
        $_SESSION[self::$sessionLocation] = $clientIdentifier;
    }

    public function logoutUser(){
        unset($_SESSION[self::$sessionLocation]);
    }

}