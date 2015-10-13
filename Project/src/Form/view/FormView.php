<?php


namespace Form\view;

use \Form\model as model;

class ViewFolderNotFoundException extends \Exception{}
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
        $ret = '<form action="" method="POST" id="' . $this->formName . '">' . PHP_EOL;
        $ret .= $this->GetErrorMessageHTML($this->inputCatalog->GetError());
        foreach($this->inputCatalog->GetAll() as $input){
            $ret .= $this->GetInputView($input);
        }
        $ret .= '</form>';
        return $ret;
    }

    private function GetInputView(model\IElement $input){
        $extension = ".php";
        $directory = "InputHTML" . DIRECTORY_SEPARATOR;
        $absoluteDirectory = __DIR__ . DIRECTORY_SEPARATOR . $directory;
        $file = $input->GetClassName() . $extension;

        if(!is_dir($absoluteDirectory)){
            throw new ViewFolderNotFoundException("Could not find the folder " . $absoluteDirectory);
        }

        if(!empty($input->GetTemplateName())){
            $template = $input->GetClassName() . '_' . $input->GetTemplateName() . $extension;

            if(is_file($absoluteDirectory . $template)){
                $file = $template;
            }

        }

        if(!is_file($absoluteDirectory . $file)){
            throw new InputViewNotFoundException("Could not find Input file {$file} in " . __DIR__ . DIRECTORY_SEPARATOR . $file);
        }

        $errormessages = $this->submitted ? $this->GetErrorMessageHTML($input->GetErrorMessage()) : '';

        ob_start();
        include($directory . $file);
        return ob_get_clean();
    }

    private function GetErrorMessageHTML(array $messages){
        $list = "";

        foreach($messages as $message){
            $list .= '<li>' . $message . '</li>' . PHP_EOL;
        }



        if(!empty($list)){
            $list = '<ul class="error-messages">' . PHP_EOL . $list . '</ul>' . PHP_EOL;
        }

        return $list;

    }

    public function GetSubmittedData(){
        return $_POST ?? array();
    }

    /*
     * Utilizes SESSION to store POST-data temporarily for use of PRG-pattern
     * PRG is only used if a session is started elsewhere in the project, this is not done by the FormHandler
     * You can also change the use of PRG in the Settings file.
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