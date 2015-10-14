<?php


namespace view;


class RegistrationView
{
    private $navigationView;
    private $model;

    private $message = "";
    private $formData = array();
    private $form;

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
        $this->form = $this->GenerateRegistrationForm();
    }

    public function GenerateRegistrationForm() : \Form\controller\FormController
    {

        $form = new \Form\controller\FormController("RegisterView::RegistrationForm");
        $form->AddInput(
            (new \Form\model\input\Text(self::$formUser, $this->GetSanitizedUsername()))
                ->SetLabel("Username:")
                ->SetValidation(
                    new \Form\model\validation\Required(self::$usernameTooShortMessage),
                    new \Form\model\validation\MinLength(3, self::$usernameTooShortMessage)
                )
            ,
            (new \Form\model\input\Password(self::$formPassword))
                    ->SetLabel("Password:")
                    ->SetValidation(
                        new \Form\model\validation\Required(self::$passwordTooShortMessage),
                        new \Form\model\validation\MinLength(6, self::$passwordTooShortMessage)
                    )
            ,
            (new \Form\model\input\Password(self::$formConfirmPassword))
                ->SetLabel("Repeat Password:")
                ->SetValidation(
                    new \Form\model\validation\Required(self::$passwordTooShortMessage),
                    new \Form\model\validation\MinLength(6, self::$passwordTooShortMessage)
                )
                ->SetComparator(new \Form\model\comparator\EqualTo(self::$formPassword, self::$passwordMismatchMessage))
            ,
            (new \Form\model\input\Submit(self::$formRegister, "Register"))
        );

        return $form;
    }

    public function UserSubmittedRegistration() : \bool
    {
        return $this->FormIsCorrect();
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
        ' . $this->form->GetView();
    }

    public function GetUserCredentials(){
        return new \model\UserCredentials($this->GetUsername(), $this->GetPassword());
    }

    private function FormIsCorrect() : \bool
    {
        if($this->form->WasSubmitted()) {
            $this->formData = $this->form->GetData();

            try {
                if (empty($this->GetUsername()) && empty($this->GetPassword())) {
                    $this->form->InjectInputError(self::$formPassword, self::$passwordTooShortMessage);
                    $this->form->InjectInputError(self::$formUser, self::$usernameTooShortMessage);
                    return false;
                }

                $uc = new \model\UserCredentials($this->GetUsername(), $this->GetPassword());

                if ($this->model->UserExists($uc)) {
                    $this->form->InjectInputError(self::$formUser, self::$userExistsMessage);
                    return false;
                }
                return true;

            } catch (\PasswordTooShortException $e) {
                $this->form->InjectInputError(self::$formPassword, self::$passwordTooShortMessage);
            } catch (\UsernameTooShortException $e) {
                $this->form->InjectInputError(self::$formUser, self::$usernameTooShortMessage);
            } catch (\PasswordMismatchException $e) {
                $this->form->InjectInputError(self::$formPassword, self::$passwordMismatchMessage);
            } catch (\UsernameInvalidException $e) {
                $this->form->InjectInputError(self::$formUser, self::$usernameInvalidMessage);
            }
        }
        return false;
    }

    private function GetPassword() : \string
    {
        if($this->formData[self::$formPassword] !== $this->formData[self::$formConfirmPassword]){
            throw new \PasswordMismatchException();
        }

        return $this->formData[self::$formPassword] ?? '';
    }

    private function GetSanitizedUsername() : \string
    {
        return htmlentities(strip_tags(str_replace(array('<a', 'a>', '<', '>', '/', ':', ';', '\\', '.', ','), '', $this->GetUsername())));
    }

    private function GetUsername() : \string
    {
        return $this->formData[self::$formUser] ?? '';
    }
}