<?php


namespace Form\controller;

require_once dirname(__DIR__) . '/model/validation/Validators.php';
require_once dirname(__DIR__) . '/Settings.php';

spl_autoload_register(function ($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $filename = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . $class . '.php';

    if(file_exists($filename)){
        require_once $filename;
    }
});

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

    public function AddInput(model\IElement $toBeAdded){
        $this->inputCatalog->Add($toBeAdded);
    }

    public function GetView(){
        return $this->view->GetView();
    }

    private function IsValid(){
        $status = true;
        foreach($this->inputCatalog->GetAll() as $input){
            $input->SetValue($this->view->GetValue($input->GetName()));
            $input->Validate();
            if(count($input->GetErrorMessage())){
                $status =  false;
            }
        }

        return $status;
    }

    public function WasSubmitted(){
        return ($this->view->WasSubmitted() && $this->IsValid());
    }
}