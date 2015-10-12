<?php


namespace Form\model\input\dev;


class Select extends \Form\model\Element
{
    private $options = array();
    public function AddOption(\Form\model\Option ...$options){
        foreach($options as $option){
            $this->options[$option->name] = $option;
        }
    }

    public function GetOptions(){
        return $this->options;
    }
}