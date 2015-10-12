<?php


namespace Form\model;

class ElementExistsException extends \Exception{}
class InputDoesNotExistException extends \Exception{}

class InputCatalog
{
    private $input = array();

    public function Add(IElement $toBeAdded){
        foreach($this->GetAll() as $input){
            if($toBeAdded->IsSame($input)){
                throw new ElementExistsException("Input with name " . $toBeAdded->GetName() . " already exist!");
            }
        }
        $this->input[$toBeAdded->GetName()] = $toBeAdded;
    }

    /**
     * @return IElement[]
     */
    public function GetAll(){
        return $this->input;
    }

    public function Get(\string $name) : IElement
    {
        if(!isset($this->input[$name])){
            throw new InputDoesNotExistException("The element you're looking for does not exist");
        }
        return $this->input[$name];
    }

    public function UpdateValues(array $data)
    {
        foreach($this->GetAll() as $input){
            $value = isset($data[$input->GetName()]) ? $data[$input->GetName()] : '';
            $input->SetValue($value);
        }
    }

    public function IsValid() : \bool
    {
        $status = true;
        foreach($this->GetAll() as $input){
            $input->Validate($this);
            if(count($input->GetErrorMessage())){
                $status =  false;
            }
        }

        return $status;
    }
}