<?php
declare(strict_types=STRICT_TYPING);

namespace view;

class PersistentLoginView
{

    // TODO: Should be changed to "PersistentLoginView::" but automated tests fail.
    private static $cookieName = "LoginView::CookieName";
    private static $cookiePassword = "LoginView::CookiePassword";

    public function GetCookieUsername() : \string
    {
        return $_COOKIE[self::$cookieName];
    }

    public function GetCookieSecurityString() : \string
    {
        return $_COOKIE[self::$cookiePassword];
    }

    public function UserHasPersistentLogin() : \bool
    {
        return isset($_COOKIE[self::$cookieName], $_COOKIE[self::$cookiePassword]);
    }

    public function StoreLogin(\model\PersistentLogin $credentials)
    {
        CookieStorage::Set(self::$cookieName, $credentials->user, $credentials->expiration);
        CookieStorage::Set(self::$cookiePassword, $credentials->passPhrase, $credentials->expiration);
    }

    public function RemovePersistentLogin()
    {

        CookieStorage::Delete(self::$cookieName);
        CookieStorage::Delete(self::$cookiePassword);

    }

}