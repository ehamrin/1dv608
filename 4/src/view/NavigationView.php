<?php


namespace view;


class NavigationView
{
    private static $registrationLocation = "register";

    public function GetBackLink() : \string
    {
        return '<a href="' . APPLICATION_URL . '">Back to login</a>';
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