<?php


namespace Form\model;

class ElementExistsException extends \Exception{}
class InputDoesNotExistException extends \Exception{}

class InputCatalog
{
    private $input = array();
    private $error = array();

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
            $input->UpdateValue($data);
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

    public function Export()
    {
        $ret = array();

        foreach($this->GetAll() as $input){
            $value = $input->Export();
            if($value !== null) {
                $ret = $this->array_merge_recursive_new($ret, $value);
            }
        }

        return $ret;

    }

    private function array_merge_recursive_new($base, ...$arrays) {
        foreach ($arrays as $array) {
            reset($base); //important
            while (list($key, $value) = @each($array)) {
                if (is_array($value) && @is_array($base[$key])) {
                    $base[$key] = $this->array_merge_recursive_new($base[$key], $value);
                } else {
                    $base[$key] = $value;
                }
            }
        }

        return $base;
    }

    public function AddError(...$messages){
        $this->error = $messages;
    }

    public function GetError(){
        return $this->error;
    }

}