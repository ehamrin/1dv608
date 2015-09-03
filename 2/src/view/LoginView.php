<?php


namespace view;


class LoginView
{
    private static $formLogin = "LoginView::LoginView";
    private static $formLogout = "LoginView::Logout";
    private static $formUser = "LoginView::UserName";
    private static $formPassword = "LoginView::Password";
    private static $formMessage = "LoginView::Message";
    private static $formKeep = "LoginView::KeepMeLoggedIn";

    private $message;

    public function UserAttemptedLogin(){
        return isset($_POST[self::$formLogin]);
    }

    public function FormIsCorrect(){
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

    public function UserPressedLogout(){
        return isset($_POST[self::$formLogout]);
    }

    public function GetUsername(){
        return isset($_POST[self::$formUser]) ? $_POST[self::$formUser] : '';
    }

    public function GetPassword(){
        return isset($_POST[self::$formPassword]) ? $_POST[self::$formPassword] : '';
    }

    public function KeepUserLoggedIn(){
        return isset($_POST[self::$formKeep]) ? $_POST[self::$formKeep] : '';
    }

    public function GetClientIdentifier(){
        return $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @return string
     */
    public function GenerateLoginForm(){

        return '
        <form method="post" >
            <fieldset>
                <legend>LoginView - enter Username and password</legend>
                <p id="' . self::$formMessage . '">' . $this->message . CookieMessageView::Retrieve() . '</p>

                <label for="' . self::$formUser . '">Username :</label>
                <input type="text" id="' . self::$formUser . '" name="' . self::$formUser . '" value="' . $this->GetUsername() . '" />

                <label for="' . self::$formPassword . '">Password :</label>
                <input type="password" id="' . self::$formPassword . '" name="' . self::$formPassword . '" />

                <label for="' . self::$formKeep . '">Keep me logged in  :</label>
                <input type="checkbox" id="' . self::$formKeep . '" name="' . self::$formKeep . '" />

                <input type="submit" name="' . self::$formLogin . '" value="login" />
            </fieldset>
        </form>';
    }

    /**
     * @return string
     */
    public function GenerateLogoutForm(){
        return '
        <form  method="post" >
				<p id="' . self::$formMessage . '">' . CookieMessageView::Retrieve() .'</p>
				<input type="submit" name="' . self::$formLogout . '" value="logout"/>
			</form>
        ';
    }


    public function SetLoginMessage(){
        CookieMessageView::Set("Welcome");
    }

    public function SetLogoutMessage(){
        CookieMessageView::Set("Bye bye!");
    }

    public function SetPersistentLoginMessage(){
        CookieMessageView::Set("Welcome and you will be remembered");
    }

    public function SetWelcomeBackMessage(){
        CookieMessageView::Set("Welcome back with cookie");
    }

    public function SetWrongCookieMessage(){
        CookieMessageView::Set("Wrong information in cookies");
    }

    public function ReloadPage(){
        header('Location: ' . APPLICATION_URL);
        //Force server to shut down script
        die();
    }

}