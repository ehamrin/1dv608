<?php


namespace Form\model;

class ElementExistsException extends \Exception{}

class InputCatalog
{
    private $input = array();

    public function Add(IElement $toBeAdded){
        foreach($this->GetAll() as $input){
            if($toBeAdded->IsSame($input)){
                throw new ElementExistsException("Input with name " . $toBeAdded->GetName() . " already exist!");
            }
        }
        $this->input[] = $toBeAdded;
    }

    /**
     * @return IElement[]
     */
    public function GetAll(){
        return $this->input;
    }
}