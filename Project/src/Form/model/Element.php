<?php


namespace Form\model;


abstract class Element implements IElement
{
    private $name;
    private $label;
    private $value;
    private $validator = array();
    private $error = array();

    public function __construct($name, $value){
        $this->name = $name;
        $this->value = $value;
    }

    public function IsSame(IElement $element){
        return $this->name == $element->GetName();
    }

    public function GetName(){
        return $this->name;
    }

    public function GetValue(){
        return $this->value;
    }

    public function SetValue($value){
        $this->value = $value;
    }

    public function SetLabel(\string $label) : Element{
        $this->label = $label;
        return $this;
    }

    public function GetLabel(){
        return $this->label;
    }

    public function SetValidation(validation\IValidation ...$validators){
        $this->validator = $validators;
        return $this;
    }

    /**
     * @return validation\IValidation[]
     */
    private function GetValidators(){
        return $this->validator;
    }

    public function Validate(){
        $valid = true;
        foreach($this->GetValidators() as $validator){
            if($validator->Validate($this->value) == FALSE){
                $valid = false;

                $this->AddError($validator->GetMessage());
            }
        }
        return $valid;
    }

    public function AddError(\string $message){
        $this->error[] = $message;
    }

    public function GetErrorMessage(){
       return $this->error;
    }
}