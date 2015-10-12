<?php


namespace Form\model\validation;

class URL extends \Form\model\Validation
{
    public function Validate($value) : \bool
    {
        return filter_var($value, FILTER_VALIDATE_URL);
    }
}