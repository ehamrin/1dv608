<?php


namespace Form\model\validation;


class MaxLength extends Validation
{
    private $max;

    public function __construct(\int $max, \string $message)
    {
        parent::__construct($message);
        $this->max = $max;
    }

    public function Validate($value) : \bool
    {
        return (is_string($value) && strlen($value) <= $this->max);
    }
}