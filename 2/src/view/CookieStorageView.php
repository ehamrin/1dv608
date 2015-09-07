<?php
declare(strict_types=1);

namespace view;


class CookieStorageView
{
    public static function Set(\string $cookieName, \string $value, \int $expiration)
    {
        setcookie($cookieName, $value, $expiration);
    }

    public static function Delete(\string $cookieName)
    {
        unset($_COOKIE[$cookieName]);
        setcookie($cookieName,null,time()-1);
    }
}