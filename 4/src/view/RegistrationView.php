<?php


namespace view;


class RegistrationView
{
    private $navigationView;
    private $model;

    private $message = "";

    private static $formUser = "RegisterView::UserName";
    private static $formPassword = "RegisterView::Password";
    private static $formConfirmPassword = "RegisterView::PasswordRepeat";
    private static $formMessage = "RegisterView::Message";
    private static $formRegister = "RegisterView::Register";

    private static $usernameTooShortMessage = "Username has too few characters, at least 3 characters.";
    private static $passwordTooShortMessage = "Password has too few characters, at least 6 characters.";
    private static $userExistsMessage = "User exists, pick another username.";
    private static $passwordMismatchMessage = "Passwords do not match.";
    private static $usernameInvalidMessage = "Username contains invalid characters.";

    public function __construct(\model\RegistrationModel $model, NavigationView $nav){
        $this->navigationView = $nav;
        $this->model = $model;
    }

    public function UserSubmittedRegistration() : \bool
    {
        return isset($_POST[self::$formRegister]) && $this->FormIsCorrect();
    }

    public function RegistrationSuccess()
    {
        RegistrationCookiePersistance::Set($this->GetUsername());
        CookieMessageView::Set("Registered new user.");
        $this->navigationView->GoToLogin();
    }

    public function GetView() : \string
    {
        return $this->navigationView->GetBackLink() . '
        <h2>Register new user</h2>
        <form method="post" >
            <fieldset>
                <legend>Register a new user - Write username and password</legend>
                <p id="' . self::$formMessage . '">' . $this->message . '</p>

                <label for="' . self::$formUser . '">Username :</label>
                <input type="text" id="' . self::$formUser . '" name="' . self::$formUser . '" value="' . strip_tags($this->GetSanitizedUsername()) . '" />

                <label for="' . self::$formPassword . '">Password :</label>
                <input type="password" id="' . self::$formPassword . '" name="' . self::$formPassword . '" />

                <label for="' . self::$formConfirmPassword . '">Repeat password :</label>
                <input type="password" id="' . self::$formConfirmPassword . '" name="' . self::$formConfirmPassword . '" />

                <input type="submit" name="' . self::$formRegister . '" value="Register" />
            </fieldset>
        </form>';
    }

    public function GetUserCredentials(){
        return new \model\UserCredentials($this->GetUsername(), $this->GetPassword());
    }

    private function FormIsCorrect() : \bool
    {

        try{
            if(empty($this->GetUsername()) && empty($this->GetPassword())){
                $this->message = self::$usernameTooShortMessage . ' ' . self::$passwordTooShortMessage;
                return false;
            }

            $uc = new \model\UserCredentials($this->GetUsername(), $this->GetPassword());

            if($this->model->UserExists($uc)){
                $this->message = self::$userExistsMessage;
                return false;
            }
            return true;

        }catch(\PasswordTooShortException $e){
            $this->message = self::$passwordTooShortMessage;
        }catch(\UsernameTooShortException $e){
            $this->message = self::$usernameTooShortMessage;
        }catch(\PasswordMismatchException $e){
            $this->message = self::$passwordMismatchMessage;
        }catch(\UsernameInvalidException $e){
            $this->message = self::$usernameInvalidMessage;
        }
        return false;
    }

    private function GetPassword() : \string
    {
        if($_POST[self::$formPassword] !== $_POST[self::$formConfirmPassword]){
            throw new \PasswordMismatchException();
        }

        return $_POST[self::$formPassword] ?? '';
    }

    private function GetSanitizedUsername() : \string
    {
        return htmlentities(strip_tags(str_replace(array('<a', 'a>', '<', '>', '/', ':', ';', '\\', '.', ','), '', $this->GetUsername())));
    }

    private function GetUsername() : \string
    {
        return $_POST[self::$formUser] ?? '';
    }
}