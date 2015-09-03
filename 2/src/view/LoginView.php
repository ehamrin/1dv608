<?php


namespace view;


class LoginView
{
    private static $formLogin = "LoginView::Login";
    private static $formLogout = "LoginView::Logout";
    private static $formUser = "LoginView::UserName";
    private static $formPassword = "LoginView::Password";
    private static $formMessage = "LoginView::Message";
    private static $formKeep = "LoginView::KeepMeLoggedIn";

    private $message;
    private $persistent_login_view;


    private $model;

    private static $fromForm = "Login through form";
    private static $fromCookie = "Login through cookie";
    private $loginMethod;


    public function __construct(\model\LoginModel $model){
        $this->persistent_login_view = new PersistentLoginView();

        $this->model = $model;
    }

    public function UserAttemptedLogin(){
        return isset($_POST[self::$formLogin]) && $this->FormIsCorrect() || $this->persistent_login_view->UserHasPersistentLogin();
    }

    private function FormIsCorrect(){
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

    public function UserPressedLogout(){
        return isset($_POST[self::$formLogout]);
    }

    private function GetUsername(){
        return isset($_POST[self::$formUser]) ? $_POST[self::$formUser] : '';
    }

    private function GetPassword(){
        return isset($_POST[self::$formPassword]) ? $_POST[self::$formPassword] : '';
    }

    private function KeepUserLoggedIn(){
        return isset($_POST[self::$formKeep]) ? $_POST[self::$formKeep] : '';
    }

    public function GetClientIdentifier(){
        return $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'];
    }

    public function LogoutUser(){
        $this->persistent_login_view->RemovePersistentLogin();
        $this->SetLogoutMessage();
    }

    public function GetUserCredentials(){
        $username = null;
        $password = null;

        if($this->FormIsCorrect()){
            $username = $this->GetUsername();
            $password = $this->GetPassword();

            $this->loginMethod = self::$fromForm;

        }else if($this->persistent_login_view->UserHasPersistentLogin()){
            $username = $this->persistent_login_view->GetCookieUsername();
            $password = $this->persistent_login_view->GetCookieSecurityString();

            $this->loginMethod = self::$fromCookie;
        }

        return new \model\UserCredentials($username, $password);
    }


    public function LoginSuccess(){

        if($this->loginMethod == self::$fromForm){
            if($this->KeepUserLoggedIn()){
                //TODO Don't generate login here
                $this->persistent_login_view->StoreLogin($this->model->GetPersistentLogin($this->GetUsername()));

                $this->SetPersistentLoginMessage();
            }
            $this->SetLoginMessage();


        }elseif($this->loginMethod == self::$fromCookie){
            $this->SetWelcomeBackMessage();
        }
    }

    public function LoginFailed(){
        if($this->loginMethod == self::$fromForm){

            $this->message = "Wrong name or password";

        }elseif($this->loginMethod == self::$fromCookie){

            $this->persistent_login_view->RemovePersistentLogin();
            $this->SetWrongCookieMessage();

        }

    }

    public function GetForm(){

        if($this->model->IsLoggedIn($this->GetClientIdentifier())){
            return $this->GetLogoutForm();
        }
        return $this->GetLoginForm();
    }

    /**
     * @return string
     */
    public function GetLoginForm(){

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
    public function GetLogoutForm(){
        return '
        <form  method="post" >
				<p id="' . self::$formMessage . '">' . CookieMessageView::Retrieve() .'</p>
				<input type="submit" name="' . self::$formLogout . '" value="logout"/>
			</form>
        ';
    }


    public function SetLoginMessage(){
        CookieMessageView::Set("Welcome");
        $this->ReloadPage();
    }

    public function SetLogoutMessage(){
        CookieMessageView::Set("Bye bye!");
        $this->ReloadPage();
    }

    public function SetPersistentLoginMessage(){
        CookieMessageView::Set("Welcome and you will be remembered");
        $this->ReloadPage();
    }

    public function SetWelcomeBackMessage(){
        CookieMessageView::Set("Welcome back with cookie");
        $this->ReloadPage();
    }

    public function SetWrongCookieMessage(){
        CookieMessageView::Set("Wrong information in cookies");
        $this->ReloadPage();
    }

    private function ReloadPage(){
        header('Location: ' . APPLICATION_URL);
        //Force server to shut down script
        die();
    }

}