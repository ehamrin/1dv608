<?php


namespace Form\controller;

require_once __DIR__ . '/model/validation/Validators.php';

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

    public function IsValid(){
        return $this->controller->IsValid();
    }
}