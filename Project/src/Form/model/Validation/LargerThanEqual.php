<?php


namespace Form\model\validation;


class LargerThanEqual extends Validation
{
    private $max;

    public function __construct(\int $max, \string $message)
    {
        parent::__construct($message);
        $this->max = $max;
    }

    public function Validate($value) : \bool
    {
        return ($value >= $this->max);
    }
}