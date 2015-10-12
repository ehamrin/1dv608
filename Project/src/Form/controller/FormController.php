<?php


namespace Form\controller;

require_once dirname(__DIR__) . '/Settings.php';

if(\Form\Settings::$UseFormAutoLoader) {
    spl_autoload_register(function ($class) {
        $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
        $filename = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . $class . '.php';

        if (file_exists($filename)) {
            require_once $filename;
        }
    });
}

use \Form\model as model;
use \Form\view as view;

class FormController
{
    private $view;
    private $inputCatalog;
    private $name;

    public function __construct(\string $formName){
        $this->name = $formName;
        $this->inputCatalog = new model\InputCatalog();
        $this->view = new view\FormView($this->name, $this->inputCatalog, \Form\Settings::$UsePRG);
    }

    public function AddInput(model\ElementFacade ...$toBeAdded){
        foreach($toBeAdded as $element){
            /* @var $element \Form\model\ElementFacade */
            $this->inputCatalog->Add($element->GetModelObject());
        }
    }

    public function GetView(){
        return $this->view->GetView();
    }

    private function IsValid(){
        $this->inputCatalog->UpdateValues($this->view->GetSubmittedData());
        return $this->inputCatalog->IsValid();
    }

    public function WasSubmitted(){
        return ($this->view->WasSubmitted() && $this->IsValid());
    }

    public function InjectInputError(\string $input, \string $message){
        $this->inputCatalog->Get($input)->AddError($message);
    }

    public function InjectFormError(\string $message){

    }

}