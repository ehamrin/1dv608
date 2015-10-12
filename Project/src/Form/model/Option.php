<?php


namespace Form\model;


class Option
{
    public $name;
    public $value;

    public function __construct($name, $value){
        $this->name = $name;
        $this->value = $value;
    }

}