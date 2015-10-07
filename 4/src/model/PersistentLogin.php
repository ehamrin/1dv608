<?php
declare(strict_types=STRICT_TYPING);

namespace model;


class PersistentLogin
{
    public $user;
    public $passPhrase;
    public $expiration;

    private static $days = 10;

    private static $salt = "1dv608";

    private $dal;

    public function __construct(\string $user){

        $this->dal = new dal\PersistentLoginDAL();
        $this->expiration = time() + 24*3600* self::$days;
        $this->passPhrase = password_hash(self::$salt . uniqid() . self::$salt, PASSWORD_BCRYPT);
        $this->user = $user;

        $this->dal->Log($this);

    }



}