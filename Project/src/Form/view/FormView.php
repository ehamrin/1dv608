<?php


namespace Form\view;

use \Form\model as model;

class InputViewNotFoundException extends \Exception{}
class ElementMissingException extends \Exception{}
class SessionMissingException extends \Exception{}

class FormView
{
    private static $sessionLocation = "Form\\FormView::SessionStorage";
    private $inputCatalog;
    private $submitted = false;
    private $formName;
    private $usePRG;

    public function __construct(\string $formName, model\InputCatalog $inputCatalog, \bool $usePRG){
        $this->formName = $formName;
        $this->usePRG = $usePRG;
        $this->inputCatalog = $inputCatalog;
    }

    public function GetView(){
        $ret = '<form action="" method="POST">';
        foreach($this->inputCatalog->GetAll() as $input){
            $ret .= $this->GetInputView($input);
        }
        $ret .= '</form>';
        return $ret;
    }

    private function GetInputView(model\IElement $input){
        $extension = ".php";
        $directory = "InputHTML/";
        $file = $input->GetClassName() . $extension;

        if(!empty($input->GetTemplateName())){
            $file = $input->GetClassName() . '_' . $input->GetTemplateName() . $extension;
        }

        if(!is_file(__DIR__ . DIRECTORY_SEPARATOR . $directory . $file)){
            throw new InputViewNotFoundException("Could not find Input file {$file} in " . __DIR__ . DIRECTORY_SEPARATOR . $file);
        }

        $errormessages = $this->submitted ? $this->GetErrorMessageHTML($input) : '';

        ob_start();
        include($directory . $file);
        return ob_get_clean();
    }

    private function GetErrorMessageHTML(model\IElement $input){
        $list = "";

        foreach($input->GetErrorMessage() as $message){
            $list .= '<li>' . $message . '</li>';
        }

        if(!empty($list)){
            $list = '<ul class="error-messages">' . $list . '</ul>';
        }

        return $list;

    }

    public function GetSubmittedData(){
        return $_POST ?? array();
    }

    /*
     * Utilizes SESSION to store POST-data temporarily for use of PRG-pattern
     * PRG is only used if a session is started elsewhere in the project, this is not not by the FormHandler
     *
     */
    public function WasSubmitted() : \bool
    {
        foreach($this->inputCatalog->GetAll() as $input){
            if($input->GetClassName() == "Submit"){

                if(session_status() === PHP_SESSION_ACTIVE && $this->usePRG == true){
                    if(isset($_POST[$input->GetName()])){
                        $_SESSION[self::$sessionLocation][$this->formName] = $_POST;
                        header('location: ' . $_SERVER["REQUEST_URI"]);
                        $this->submitted = true;
                        return true;
                    }elseif(isset($_SESSION[self::$sessionLocation][$this->formName][$input->GetName()])){
                        $_POST = $_SESSION[self::$sessionLocation][$this->formName];
                        unset($_SESSION[self::$sessionLocation][$this->formName]);
                        $this->submitted = true;
                        return true;
                    }
                }else{
                    if(isset($_POST[$input->GetName()])) {
                        $this->submitted = true;
                        return true;
                    }
                }
            }
        }
        return false;
    }
}