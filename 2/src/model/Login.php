<?php


namespace model;


class Login
{
    //User credentials
    private static $username = "Admin";
    private static $password = "Password";


    private static $sessionLocation = "\\Model\\Login::Logged_In";

    private $p_dal;

    public function __construct(){
        $this->p_dal = new dal\PersistentLogin();
    }

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

    public function authenticatePersistentLogin($username, $cookieString){
        return $this->p_dal->matchRecord($username, $cookieString);
    }

    public function generatePersistentLogin($user){

        $login = new PersistentLogin($user);

        $this->p_dal->log($login);

        return $login;
    }

    public function matchPersistentLogin($user, $securityString){

        return $this->p_dal->matchRecord($user, $securityString);
    }

    public function loginUser($clientIdentifier){
        $_SESSION[self::$sessionLocation] = $clientIdentifier;
    }

    public function logoutUser(){
        unset($_SESSION[self::$sessionLocation]);
    }

}