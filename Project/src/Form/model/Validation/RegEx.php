<?php


namespace Form\model\validation;


class RegEx extends \Form\model\Validation
{
    private $regex;

    public function __construct(\string $regex, \string $message)
    {
        parent::__construct($message);
        $this->regex = $regex;
    }

    public function Validate($value) : \bool
    {
        return preg_match($this->regex , $value);
    }
}