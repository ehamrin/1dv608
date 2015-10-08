<?php


namespace view;


class NavigationView
{
    private static $registrationLocation = "register";

    public function inRegistration() : \string
    {
        return isset($_GET[self::$registrationLocation]);
    }

    public function GetBackLink() : \string
    {
        return '<a href="' . APPLICATION_URL . '">Back to login</a>';
    }

    public function GoToLogin()
    {
        header('Location: ' . APPLICATION_URL);
        //Force server to shut down script
        die();
    }

    public function GetRegistrationLink() : \string
    {
        return '<a href="' . APPLICATION_URL . '?' . self::$registrationLocation . '">Register a new user</a>';
    }

    public function UserNavigatesToRegistration() : \bool
    {
        return isset($_GET[self::$registrationLocation]);
    }
}