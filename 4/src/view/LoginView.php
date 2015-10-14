<?php
declare(strict_types=STRICT_TYPING);

namespace view;

require_once APPLICATION_URI . 'vendors/Form/controller/FormController.php';

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

    private $formData = array();
    private $form;
    private $logoutform;

    private $loginMethod;
    private $persistent_login_view;
    private $model;
    private $navigationView;

    public function __construct(\model\LoginModel $model, NavigationView $nv)
    {
        $this->persistent_login_view = new PersistentLoginView();
        $this->model = $model;
        $this->navigationView = $nv;
        $this->form = $this->GenerateLoginForm();
        $this->logoutform = $this->GenerateLogoutForm();
    }

    public function GenerateLoginForm() : \Form\controller\FormController
    {

        $form = new \Form\controller\FormController("LoginView::LoginForm");
        $form->AddInput(
            (new \Form\model\input\Text(self::$formUser))
                ->SetLabel("Username:")
                ->SetValidation(
                    new \Form\model\validation\Required("Username missing")
                )
            ,
            (new \Form\model\input\Password(self::$formPassword))
                ->SetLabel("Password:")
                ->SetValidation(
                    new \Form\model\validation\Required("Password missing")
                )
            ,
            (new \Form\model\input\Checkbox(self::$formKeep))
                ->SetLabel("Keep me logged in:")
            ,
            (new \Form\model\input\Submit(self::$formLogin, "Log in"))
        );

        return $form;
    }
    public function GenerateLogoutForm() : \Form\controller\FormController
    {

        $form = new \Form\controller\FormController("LoginView::LoginForm");
        $form->AddInput(
            (new \Form\model\input\Submit(self::$formLogout, "Log out"))
        );

        return $form;
    }
    public function UserAttemptedLogin() : \bool
    {
        return $this->FormIsCorrect() || $this->persistent_login_view->UserHasPersistentLogin();
    }

    public function UserAttemptedLogout() : \bool
    {
        return $this->logoutform->WasSubmitted();
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

        return new \model\UserCredentials($username, $password, $this->GetClientIdentifier());
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

            $this->form->InjectFormError("Wrong name or password");

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

    public function GetView() : \string
    {

        if($this->model->IsLoggedIn($this->GetClientIdentifier())){
            return $this->GetLogoutForm();
        }
        return $this->GetLoginForm();
    }

    private function FormIsCorrect() : \bool
    {
        if($this->form->WasSubmitted()) {
            $this->formData = $this->form->GetData();

            try {
                new \model\UserCredentials($this->GetUsername(), $this->GetPassword());
                return true;
            } catch (\PasswordTooShortException $e) {
                $this->form->InjectFormError("Password is missing");
            } catch (\UsernameTooShortException $e) {
                $this->form->InjectFormError("Username is missing");
            } catch (\Exception $e) {
                $this->form->InjectFormError("Wrong name or password");
            }
        }
        return false;
    }

    private function GetUsername() : \string
    {
        if(isset($this->formData[self::$formUser])){
            return $this->formData[self::$formUser];
        }

        return RegistrationCookiePersistance::Retrieve();
    }

    private function GetPassword() : \string
    {
        return $this->formData[self::$formPassword] ?? '';
    }

    private function KeepUserLoggedIn() : \bool
    {
        return $this->formData[self::$formKeep];
    }

    private function GetLoginForm() : \string
    {
        $message = CookieMessageView::Retrieve();
        if(!empty($message)){
            $message = '<p class="info">' . $message . '</p>';
        }

        return $this->navigationView->GetRegistrationLink() . $message . $this->form->GetView();
    }

    private function GetLogoutForm() : \string
    {
        $message = CookieMessageView::Retrieve();
        if(!empty($message)){
            $message = '<p class="info" id="' . self::$formMessage . '">' . $message . '</p>';
        }
        return $message . $this->logoutform->GetView();
    }

    private function SetTemporaryMessage(\string $message)
    {
        CookieMessageView::Set($message);
        $this->navigationView->GoToLogin();
    }

}