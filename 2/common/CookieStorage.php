<?php
declare(strict_types=STRICT_TYPING);

namespace view;


class CookieStorage
{
    public static function Set(\string $cookieName, \string $value, \int $expiration)
    {
        setcookie($cookieName, $value, $expiration);
    }

    public static function Delete(\string $cookieName)
    {
        unset($_COOKIE[$cookieName]);
        setcookie($cookieName,"",time()-1);
    }
}