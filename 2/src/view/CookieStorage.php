<?php


namespace view;


class CookieStorage
{
    public static function Set($cookieName, $value, $expiration){
        setcookie($cookieName, $value, $expiration);
    }

    public static function Delete($cookieName){
        unset($_COOKIE[$cookieName]);
        setcookie($cookieName,null,time()-1);
    }
}