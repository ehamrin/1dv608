<?php


namespace Form\model\input\dev;


class Checkbox extends \Form\model\Element
{
    public function Export(){
        if(\Form\Settings::$PopulateCheckboxIndex == true){
            return (bool)$this->GetValue();
        }elseif(\Form\Settings::$PopulateCheckboxIndex == false && !empty($this->GetValue())){
            return $this->GetValue();
        }

        return null;
    }
}