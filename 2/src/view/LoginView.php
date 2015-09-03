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
        return isset($_POST[self::$formUser]) ? $_POST[self::$formUser] : '';
    }

    public function getPassword(){
        return isset($_POST[self::$formPassword]) ? $_POST[self::$formPassword] : '';
    }

    public function keepUserLoggedIn(){
        return isset($_POST[self::$formKeep]) ? $_POST[self::$formKeep] : '';
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


        return '
        <form method="post" >
            <fieldset>
                <legend>LoginView - enter Username and password</legend>
                <p id="' . self::$formMessage . '">' . $this->message . CookieMessageView::Retrieve() . '</p>

                <label for="' . self::$formUser . '">Username :</label>
                <input type="text" id="' . self::$formUser . '" name="' . self::$formUser . '" value="' . $this->getUsername() . '" />

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
				<p id="' . self::$formMessage . '">' . CookieMessageView::Retrieve() .'</p>
				<input type="submit" name="' . self::$formLogout . '" value="logout"/>
			</form>
        ';
    }


    public function setLoginMessage(){
        CookieMessageView::Set("Welcome");
    }

    public function setLogoutMessage(){
        CookieMessageView::Set("Bye bye!");
    }

    public function setPersistentLoginMessage(){
        CookieMessageView::Set("Welcome and you will be remembered");
    }

    public function setWelcomeBackMessage(){
        CookieMessageView::Set("Welcome back with cookie");
    }

    public function setWrongCookieMessage(){
        CookieMessageView::Set("Wrong information in cookies");
    }

    public function reloadPage(){
        header('Location: ' . APPLICATION_URL);
        //Force server to shut down script
        die();
    }

    //TODO Refactor to PersistentLoginModel View class
    public function userHasPersistentLogin(){
        return isset($_COOKIE[self::$cookieName], $_COOKIE[self::$cookiePassword]);
    }

    public function storeLogin(\model\PersistentLoginModel $credentials){
        CookieStorageView::Set(self::$cookieName, $credentials->user, $credentials->expiration);
        CookieStorageView::Set(self::$cookiePassword, $credentials->securityString, $credentials->expiration);
    }

    public function removePersistentLogin(){

        CookieStorageView::Delete(self::$cookieName);
        CookieStorageView::Delete(self::$cookiePassword);

    }
}