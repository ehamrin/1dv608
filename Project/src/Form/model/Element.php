<?php


namespace Form\model;


abstract class Element implements IElement
{
    private $name;
    private $label;
    private $value;
    private $template;
    private $validator = array();
    private $comparator = array();
    private $error = array();

    public function __construct($name, $value = "")
    {
        $this->name = $name;
        $this->value = $value;
        $this->template = "";
    }

    public function IsSame(IElement $element)
    {
        return $this->name == $element->GetName();
    }

    public function GetName(){
        return $this->name;
    }

    public function SetTemplateName(\string $name)
    {
        $this->template = $name;
    }

    public function GetTemplateName() : \string
    {
        return $this->template;
    }

    public function GetValue()
    {
        return $this->value;
    }

    public function SetValue($value)
    {
        $this->value = $value;
    }

    public function SetLabel(\string $label)
    {
        $this->label = $label;
    }

    public function GetLabel()
    {
        return $this->label;
    }

    public function SetValidation(IValidation ...$validators)
    {
        $this->validator = $validators;
    }

    /**
     * @return IValidation[]
     */
    private function GetValidators()
    {
        return $this->validator;
    }

    public function SetComparator(IComparator ...$comparators){
        $this->comparator = $comparators;
    }

    /**
     * @return IComparator[]
     */
    private function GetComparator(){
        return $this->comparator;
    }


    public function Validate(InputCatalog $catalog){
        $valid = true;

        foreach($this->GetValidators() as $key => $validator){
            if($validator->Validate($this->value) == FALSE){
                $valid = false;
                $this->AddError($validator->GetMessage(), $key);

            }
        }

        foreach($this->GetComparator() as $key => $comparator){
            $key += count($this->GetValidators()); //Offset index in array by number of validators

            $toCompare = $catalog->Get($comparator->GetName());
            if($comparator->Validate($this->value, $toCompare->GetValue()) == FALSE){
                $valid = false;
                $this->AddError($comparator->GetMessage(), $key);
            }
        }
        return $valid;
    }

    public function AddError(\string $message, \string $key = null){
        if($key == null){
            $key = count($this->error);
        }
        $this->error[$key] = $message;
    }

    public function GetErrorMessage(){
       return $this->error;
    }

    public function GetClassName(){
        $class = get_class($this);
        $array = explode('\\', $class);
        return array_pop($array);
    }
}