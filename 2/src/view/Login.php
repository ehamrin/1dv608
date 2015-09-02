<?php


namespace view;


class Login
{
    private static $formLogin = "LoginView::Login";
    private static $formLogout = "LoginView::Logout";
    private static $formUser = "LoginView::UserName";
    private static $formPassword = "LoginView::Password";
    private static $formMessage = "LoginView::Message";
    private static $formKeep = "LoginView::KeepMeLoggedIn";

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
        <form method="post" >
            <fieldset>
                <legend>Login - enter Username and password</legend>
                <p id="' . self::$formMessage . '">' . $this->message . CookieMessage::Retrieve() . '</p>

                <label for="' . self::$formUser . '">Username :</label>
                <input type="text" id="' . self::$formUser . '" name="' . self::$formUser . '" value="" />

                <label for="' . self::$formPassword . '">Password :</label>
                <input type="password" id="' . self::$formPassword . '" name="' . self::$formPassword . '" />

                <label for="' . self::$formKeep . '">Keep me logged in  :</label>
                <input type="checkbox" id="' . self::$formKeep . '" name="' . self::$formKeep . '" />

                <input type="submit" name="' . self::$formLogin . '" value="login" />
            </fieldset>
        </form>';
    }

    public function showLogout(){
        return '
        <form  method="post" >
				<p id="' . self::$formMessage . '">' . CookieMessage::Retrieve() .'</p>
				<input type="submit" name="' . self::$formLogout . '" value="logout"/>
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