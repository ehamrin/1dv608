<?php


namespace Form\model;


interface IElement
{
    public function IsSame(IElement $element);
    public function GetName();

    public function SetLabel(\string $label);
    public function GetLabel();
}