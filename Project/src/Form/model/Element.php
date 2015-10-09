<?php


namespace Form\model;


abstract class Element implements IElement
{
    private $name;
    private $label;

    public function __construct($name){
        $this->name = $name;
    }

    public function IsSame(IElement $element){
        return $this->name == $element->GetName();
    }

    public function GetName(){
        return $this->name;
    }

    public function SetLabel(\string $label) : Element{
        $this->label = $label;
        return $this;
    }

    public function GetLabel(){
        return $this->label;
    }
}