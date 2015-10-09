<?php


namespace Form\controller;

spl_autoload_register(function ($class) {
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class);
    $filename = dirname(__DIR__) . DIRECTORY_SEPARATOR . $class . '.php';

    if(file_exists($filename)){
        require_once $filename;
    }
});

class FormFacade
{
    private $controller;

    public function __construct(){
        $this->controller = new FormController();
    }

    public function AddInput(\Form\model\IElement $toBeAdded){
        $this->controller->Add($toBeAdded);
    }

    public function Render() : \string
    {
        return $this->controller->GetView();
    }
}