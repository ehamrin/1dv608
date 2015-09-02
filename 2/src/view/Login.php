<?php


namespace view;


class Login
{
    private static $formLogin = "Login_Submit";
    private static $formLogout = "Logout_Submit";
    private static $formUser = "username";
    private static $formPassword = "password";

    private $message;

    public function userAttemptedLogin(){
        return isset($_POST[self::$formLogin]);
    }

    public function formIsCorrect(){
        if(empty($_POST[self::$formUser])){
            $this->message = "Username is missing";
            return false;
        }

        if(empty($_POST[self::$formPassword])) {
            $this->message = "Password is missing";
            return false;
        }

        return true;
    }

    public function getUsername(){
        return $_POST[self::$formUser];
    }

    public function getPassword(){
        return $_POST[self::$formPassword];
    }

    public function showForm(){
        $username = $this->userAttemptedLogin() ? $_POST[self::$formUser] : null;

        return '
        <h2>Not logged in</h2>
        <form method="POST">
            <fieldset>
                <legend>Login - enter username and password</legend>
                ' . $this->message . '
                <input type="text" name="' . self::$formUser . '" value="' . $username . '"/>
                <input type="password" name="' . self::$formPassword . '"/>
                <input type="submit" name="' . self::$formLogin . '" value="Log in"/>
            </fieldset>
        </form>
        ';
    }

    public function showLogout(){
        return '
        <h2>Logged in</h2>
        <form method="POST">
            <fieldset>
                <legend>Logout</legend>
                <input type="submit" name="' . self::$formLogout . '" value="Log out"/>
            </fieldset>
        </form>
        ';
    }
}