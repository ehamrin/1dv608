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
    private static $cookieName = "LoginView::CookieName";
    private static $cookiePassword = "LoginView::CookiePassword";

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

    public function keepUserLoggedIn(){
        return $_POST[self::$formKeep];
    }

    public function getCookieUsername(){
        return $_COOKIE[self::$cookieName];
    }

    public function getCookieSecurityString(){
        return $_COOKIE[self::$cookiePassword];
    }

    public function getClientIdentifier(){
        return $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'];
    }

    public function generateLoginForm(){

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
                <input type="text" id="' . self::$formUser . '" name="' . self::$formUser . '" value="' . $username . '" />

                <label for="' . self::$formPassword . '">Password :</label>
                <input type="password" id="' . self::$formPassword . '" name="' . self::$formPassword . '" />

                <label for="' . self::$formKeep . '">Keep me logged in  :</label>
                <input type="checkbox" id="' . self::$formKeep . '" name="' . self::$formKeep . '" />

                <input type="submit" name="' . self::$formLogin . '" value="login" />
            </fieldset>
        </form>';
    }

    public function generateLogoutForm(){
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

    public function setPersistentLoginMessage(){
        CookieMessage::Set("Welcome and you will be remembered");
    }

    public function setWelcomeBackMessage(){
        CookieMessage::Set("Welcome back with cookie");
    }

    public function setWrongCookieMessage(){
        CookieMessage::Set("Wrong information in cookies");
    }

    public function reloadPage(){
        header('Location: ' . APPLICATION_URL);
        //Force server to shut down script
        die();
    }

    public function userHasPersistentLogin(){
        return isset($_COOKIE[self::$cookieName], $_COOKIE[self::$cookiePassword]);
    }

    public function storeLogin(\model\PersistentLogin $credentials){
        setcookie(self::$cookieName, $credentials->user, $credentials->expiration);
        setcookie(self::$cookiePassword, $credentials->securityString, $credentials->expiration);
    }

    public function removePersistentLogin(){

        unset($_COOKIE[self::$cookieName]);
        setcookie(self::$cookieName, null, time()-1);

        unset($_COOKIE[self::$cookiePassword]);
        setcookie(self::$cookiePassword, null, time()-1);

    }
}