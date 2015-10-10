<?php


namespace Form\controller;

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

    public function Add(model\IElement $toBeAdded){
        $this->inputCatalog->Add($toBeAdded);
    }

    public function GetView(){
        return $this->view->GetView();
    }

    public function IsValid(){

        foreach($this->inputCatalog->GetAll() as $input){
            if($input->Validate() == false){
                return false;
            }
        }

        return true;
    }
}