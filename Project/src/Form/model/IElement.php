<?php


namespace Form\model;


interface IElement
{
    public function IsSame(IElement $element);
    public function GetName();

    public function SetLabel(\string $label);
    public function GetLabel();
    public function SetTemplateName(\string $name);
    public function GetTemplateName() : \string;
    public function Validate(\Form\model\InputCatalog $catalog);
    public function GetErrorMessage();
    public function GetClassName();
    public function GetValue();
    public function Export();
    public function SetValue($value);
    public function AddError(\string $message, \string $key = null);
}