<?php


namespace view;


class RegistrationView
{
    private $nv;
    private $model;

    private $message = "";

    private static $formUser = "RegisterView::UserName";
    private static $formPassword = "RegisterView::Password";
    private static $formConfirmPassword = "RegisterView::PasswordRepeat";
    private static $formMessage = "RegisterView::Message";
    private static $formRegister = "RegisterView::Register";

    public function __construct(\model\LoginModel $lm, NavigationView $nav){
        $this->nv = $nav;
        $this->model = $lm;
    }

    public function UserAttemptedRegistration() : \bool
    {
        return isset($_POST[self::$formRegister]) && $this->FormIsCorrect();
    }

    public function GetForm() : \string
    {
        return $this->nv->GetBackLink() . '
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
                $this->message = "Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.";
                return false;
            }

            $uc = new \model\UserCredentials($this->GetUsername(), $this->GetPassword());

            if($this->model->UserExists($uc)){
                $this->message = "User exists, pick another username.";
                return false;
            }
            return true;

        }catch(\PasswordTooShortException $e){
            $this->message = "Password has too few characters, at least 6 characters.";
        }catch(\UsernameTooShortException $e){
            $this->message = "Username has too few characters, at least 3 characters.";
        }catch(\PasswordMismatchException $e){
            $this->message = "Passwords do not match.";
        }catch(\UsernameInvalidException $e){
            $this->message = "Username contains invalid characters.";
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