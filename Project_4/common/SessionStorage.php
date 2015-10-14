<?php
declare(strict_types=STRICT_TYPING);

namespace model\dal;


abstract class SessionStorage
{
    private static $sessionLocation = "\\Model\\DAL\\SessionStorage";

    public function Get()
    {
        return $_SESSION[self::$sessionLocation] ?? null;
    }

    public function Save($identifier){
        $_SESSION[self::$sessionLocation] = $identifier;
    }

    public function Remove(){
        unset($_SESSION[self::$sessionLocation]);
    }

}