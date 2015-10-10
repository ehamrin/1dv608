<?php


namespace Form\controller;

require_once dirname(__DIR__) . '/Settings.php';

spl_autoload_register(function ($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $filename = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . $class . '.php';

    if(file_exists($filename)){
        require_once $filename;
    }
});

class UnknownClassException extends \Exception{}

use \Form\model as model;
use \Form\view as view;

class FormController
{
    private $view;
    private $inputCatalog;

    public function __construct(){
        $this->inputCatalog = new model\InputCatalog();
        $this->view = new view\FormView($this->inputCatalog);
    }

    public function AddInput(model\IElement ...$toBeAdded){
        foreach($toBeAdded as $element){
            $this->inputCatalog->Add($element);
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

    public function InjectError(\string $input, \string $message){
        $this->inputCatalog->Get($input)->AddError($message);
    }

}