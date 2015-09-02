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

        //If both are filled out correctly, the message will only be shown if login was unsuccessful.
        $this->message = "Wrong name or password";

        return true;
    }

    public function userPressedLogout(){
        return isset($_POST[self::$formLogout]);
    }

    public function getUsername(){
        return $_POST[self::$formUser];
    }

    public function getPassword(){
        return $_POST[self::$formPassword];
    }

    public function showForm(){

        $username = null;

        if($this->userAttemptedLogin()){
            $username = $_POST[self::$formUser];
        }

        return '
        <h2>Not logged in</h2>
        <form method="POST">
            <fieldset>
                <legend>Login - enter username and password</legend>
                <p>' . $this->message . ' ' . CookieMessage::Retrieve() . '</p>
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
                <p>' . CookieMessage::Retrieve() . '</p>
                <input type="submit" name="' . self::$formLogout . '" value="Log out"/>
            </fieldset>
        </form>
        ';
    }

    public function setLoginMessage(){
        CookieMessage::Set("Welcome");
    }

    public function setLogoutMessage(){
        CookieMessage::Set("Bye bye!");
    }

    public function reloadPage(){
        header('Location: ' . $_SERVER['PHP_SELF']);
        //Force server to shut down script
        die();
    }
}