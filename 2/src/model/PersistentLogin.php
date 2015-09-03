<?php


namespace model;


class PersistentLogin
{
    public $user;
    public $securityString;
    public $expiration;

    private static $days = 10;

    private static $salt = "1dv608";

    public function __construct($user){
        $this->expiration = time() + 24*3600* self::$days;
        $this->securityString = password_hash(self::$salt . uniqid() . self::$salt, PASSWORD_BCRYPT);
        $this->user = $user;

    }

}