<?php


namespace view;


class RegistrationCookiePersistance
{
    private static $locationName = "RegistrationMessageView";

    public static function Set(\string $message)
    {

        $number_of_days = 30;
        $date_of_expiry = time() + 60 * 60 * 24 * $number_of_days;

        CookieStorage::Set(self::$locationName, $message, $date_of_expiry);

    }

    public static function Retrieve() : \string
    {
        $message = "";

        if(isset($_COOKIE[self::$locationName])){
            $message = $_COOKIE[self::$locationName];
        }

        CookieStorage::Delete(self::$locationName);

        return $message;
    }
}