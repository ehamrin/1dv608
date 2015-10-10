<?php


namespace Form;

use \PHPUnit_Framework_TestCase;

class LessThanEqualValidator extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function LessThanEqualSucceedsOnEqual()
    {
        $validator = new \Form\model\validation\LessThanEqual(3, "message");
        $this->assertTrue($validator->Validate(3));
    }

    /**
     * @test
     */
    public function LessThanEqualSucceedsOnLower()
    {
        $validator = new \Form\model\validation\LessThanEqual(3, "message");
        $this->assertTrue($validator->Validate(2));
    }

    /**
     * @test
     */
    public function LessThanEqualFailsOnHigher()
    {
        $validator = new \Form\model\validation\LessThanEqual(3, "message");
        $this->assertFalse($validator->Validate(4));
    }

}
