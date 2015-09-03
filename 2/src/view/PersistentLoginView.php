<?php


namespace view;


class PersistentLoginView
{

    // TODO: Should be changed to "PersistentLoginView::" but automated tests fail.
    private static $cookieName = "LoginView::CookieName";
    private static $cookiePassword = "LoginView::CookiePassword";

    public function getCookieUsername(){
        return $_COOKIE[self::$cookieName];
    }

    public function getCookieSecurityString(){
        return $_COOKIE[self::$cookiePassword];
    }

    public function userHasPersistentLogin(){
        return isset($_COOKIE[self::$cookieName], $_COOKIE[self::$cookiePassword]);
    }

    public function storeLogin(\model\PersistentLoginModel $credentials){
        CookieStorageView::Set(self::$cookieName, $credentials->user, $credentials->expiration);
        CookieStorageView::Set(self::$cookiePassword, $credentials->passPhrase, $credentials->expiration);
    }

    public function removePersistentLogin(){

        CookieStorageView::Delete(self::$cookieName);
        CookieStorageView::Delete(self::$cookiePassword);

    }

}