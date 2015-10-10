<?php


namespace Form\model;


interface IElement
{
    public function IsSame(IElement $element);
    public function GetName();

    public function SetLabel(\string $label);
    public function GetLabel();
    public function Validate();
    public function GetErrorMessage();
    public function GetClassName();
    public function GetValue();
    public function SetValue($value);
}