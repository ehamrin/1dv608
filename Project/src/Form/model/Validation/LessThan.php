<?php


namespace Form\model\validation;


class LessThan extends Validation
{
    private $min;

    public function __construct(\int $min, \string $message)
    {
        parent::__construct($message);
        $this->min = $min;
    }

    public function Validate($value) : \bool
    {
        return ($value > $this->min);
    }
}