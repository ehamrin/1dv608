<?php


namespace model;


class Login
{
    //User credentials
    private static $username = "Admin";
    private static $password = "Password";


    private static $sessionLocation = "\\Model\\Login::Logged_In";

    public function isLoggedIn()
    {
        return isset($_SESSION[self::$sessionLocation]);
    }

    public function authenticateLogin($username, $password){
        if($username === self::$username && $password === self::$password){
            $this->loginUser();
        }
    }

    private function loginUser(){
        $_SESSION[self::$sessionLocation] = true;
    }

    private function logoutUser(){
        unset($_SESSION[self::$sessionLocation]);
    }

}