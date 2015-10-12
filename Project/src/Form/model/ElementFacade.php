<?php


namespace Form\model;


abstract class ElementFacade
{
    private $object;

    public function __construct($name, $value = ""){
        $classname = array_pop(explode('\\', get_class($this)));
        $class = "\\Form\\model\\input\\dev\\" . $classname;
        $object = new $class($name, $value);

        /*
         * @var $object \Form\model\IElement
         */
        $this->object = $object;
    }

    public function SetTemplateName(\string $name){
        $this->object->SetTemplateName($name);
        return $this;
    }

    public function SetValue($value){
        $this->object->SetValue($value);
        return $this;
    }

    public function SetLabel(\string $label)
    {
        $this->object->SetLabel($label);
        return $this;
    }

    public function SetValidation(IValidation ...$validators){
        $this->object->SetValidation(...$validators);
        return $this;
    }

    public function SetComparator(IComparator ...$comparators){
        $this->object->SetComparator(...$comparators);
        return $this;
    }

    public function GetModelObject() : IElement
    {
        return $this->object;
    }
}