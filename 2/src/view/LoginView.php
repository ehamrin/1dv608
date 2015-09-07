<?php
declare(strict_types=1);

namespace view;

class LoginView
{
    private static $formLogin = "LoginView::Login";
    private static $formLogout = "LoginView::Logout";
    private static $formUser = "LoginView::UserName";
    private static $formPassword = "LoginView::Password";
    private static $formMessage = "LoginView::Message";
    private static $formKeep = "LoginView::KeepMeLoggedIn";
    private static $fromForm = "Login through form";
    private static $fromCookie = "Login through cookie";

    private $loginMethod;
    private $message;
    private $persistent_login_view;
    private $model;

    public function __construct(\model\LoginModel $model)
    {
        $this->persistent_login_view = new PersistentLoginView();
        $this->model = $model;
    }

    public function UserAttemptedLogin() : \bool
    {
        return isset($_POST[self::$formLogin]) && $this->FormIsCorrect() || $this->persistent_login_view->UserHasPersistentLogin();
    }

    public function UserPressedLogout() : \bool
    {
        return isset($_POST[self::$formLogout]);
    }

    public function GetClientIdentifier() : \string
    {
        return $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'];
    }

    public function GetUserCredentials() : \model\UserCredentials
    {
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


    public function LoginSuccess()
    {
        if($this->loginMethod == self::$fromForm){
            if($this->KeepUserLoggedIn()){
                //TODO Don't generate login here
                $this->persistent_login_view->StoreLogin($this->model->GetPersistentLogin($this->GetUsername()));

                $this->SetTemporaryMessage("Welcome and you will be remembered");
            }
            $this->SetTemporaryMessage("Welcome");

        }elseif($this->loginMethod == self::$fromCookie){
            $this->SetTemporaryMessage("Welcome back with cookie");
        }
    }

    public function LoginFailed()
    {
        if($this->loginMethod == self::$fromForm){

            $this->message = "Wrong name or password";

        }elseif($this->loginMethod == self::$fromCookie){

            $this->persistent_login_view->RemovePersistentLogin();
            $this->SetTemporaryMessage("Wrong information in cookies");

        }

    }

    public function LogoutUser()
    {
        $this->persistent_login_view->RemovePersistentLogin();
        $this->SetTemporaryMessage("Bye bye!");
    }

    public function GetForm() : \string
    {

        if($this->model->IsLoggedIn($this->GetClientIdentifier())){
            return $this->GetLogoutForm();
        }
        return $this->GetLoginForm();
    }

    private function FormIsCorrect() : \bool
    {
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

    private function GetUsername() : \string
    {
        return $_POST[self::$formUser] ?? '';
    }

    private function GetPassword() : \string
    {
        return $_POST[self::$formPassword] ?? '';
    }

    private function KeepUserLoggedIn() : \bool
    {
        return $_POST[self::$formKeep] ?? false;
    }

    private function GetLoginForm() : \string
    {

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

    private function GetLogoutForm() : \string
    {
        return '
        <form  method="post" >
				<p id="' . self::$formMessage . '">' . CookieMessageView::Retrieve() .'</p>
				<input type="submit" name="' . self::$formLogout . '" value="logout"/>
			</form>
        ';
    }

    private function SetTemporaryMessage(\string $message)
    {
        CookieMessageView::Set($message);
        $this->ReloadPage();
    }

    private function ReloadPage()
    {
        header('Location: ' . APPLICATION_URL);
        //Force server to shut down script
        die();
    }

}