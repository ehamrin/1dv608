<?php


namespace Form\model\validation;


interface IValidation
{
    public function Validate($value) : \bool ;
    public function GetMessage() : \string ;
}