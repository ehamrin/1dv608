<?php
declare(strict_types=1);

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

    public function StoreLogin(\model\PersistentLoginModel $credentials)
    {
        CookieStorageView::Set(self::$cookieName, $credentials->user, $credentials->expiration);
        CookieStorageView::Set(self::$cookiePassword, $credentials->passPhrase, $credentials->expiration);
    }

    public function RemovePersistentLogin()
    {

        CookieStorageView::Delete(self::$cookieName);
        CookieStorageView::Delete(self::$cookiePassword);

    }

}