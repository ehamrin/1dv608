<?php


namespace Form\model\validation;


abstract class Validation implements IValidation
{
    private $message;
    public function __construct(\string $message){
        $this->message = $message;
    }

    public function GetMessage() : \string
    {
        return $this->message;
    }
}