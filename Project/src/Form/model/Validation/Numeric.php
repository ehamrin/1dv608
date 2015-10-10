<?php


namespace Form\model\validation;


class Numeric extends Validation
{
    public function Validate($value) : \bool
    {
        return is_numeric($value);
    }
}
