<?php


namespace Form\model\input\dev;


class Checkbox extends \Form\model\Element
{
    public function GetValue()
    {
        return (bool)$this->value;
    }
}