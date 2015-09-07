<?php
declare(strict_types=1);

namespace model;


class PersistentLoginModel
{
    public $user;
    public $passPhrase;
    public $expiration;

    private static $days = 10;

    private static $salt = "1dv608";

    public function __construct(\string $user){
        $this->expiration = time() + 24*3600* self::$days;
        $this->passPhrase = password_hash(self::$salt . uniqid() . self::$salt, PASSWORD_BCRYPT);
        $this->user = $user;

    }

}