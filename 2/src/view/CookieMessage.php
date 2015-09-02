<?php


namespace view;


class CookieMessage
{
    private static $locationName = "CookieMessage";

    public static function Set($message){

        $number_of_days = 30;
        $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;

        setcookie(self::$locationName, $message, $date_of_expiry );

    }

    public static function Retrieve(){
        $message = null;

        if(isset($_COOKIE[self::$locationName])){
            $message = $_COOKIE[self::$locationName];
        }

        unset($_COOKIE[self::$locationName]);
        setcookie(self::$locationName,null,time()-1);

        return $message;
    }
}