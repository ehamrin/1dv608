<?php


namespace model;


class PersistentLogin
{
    public $user;
    public $securityString;
    public $expiration;

    private static $salt = "1dv608";

    public function __construct($user){
        $this->expiration = time() + 24*3600;
        $this->securityString = sha1(self::$salt . uniqid() . self::$salt);
        $this->user = $user;

    }

}