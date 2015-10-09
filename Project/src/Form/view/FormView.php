<?php


namespace Form\view;

use \Form\model as model;

class InputViewNotFoundException extends \Exception{}

class FormView
{
    private $inputCatalog;

    public function __construct(model\InputCatalog $inputCatalog){
        $this->inputCatalog = $inputCatalog;
    }

    public function GetView(){
        $ret = "";
        foreach($this->inputCatalog->GetAll() as $input){

            $class = array_pop(explode('\\', get_class($input)));
            $file = "InputHTML/" . $class . '.php';

            if(!is_file(__DIR__ . DIRECTORY_SEPARATOR . $file)){
                throw new InputViewNotFoundException("Could not find Input file {$class} in " . __DIR__ . DIRECTORY_SEPARATOR . $file);
            }

            ob_start();
            include($file);
            $ret .= ob_get_clean();
        }
        return $ret;
    }
}