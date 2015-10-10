<?php


namespace Form;

use \PHPUnit_Framework_TestCase;

class ValidationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function LargerThanEqualSucceedsOnEqual()
    {
        $validator = new \Form\model\validation\LargerThanEqual(3, "message");
        $this->assertTrue($validator->Validate(3));
    }

    /**
     * @test
     */
    public function LargerThanEqualFailsOnLower()
    {
        $validator = new \Form\model\validation\LargerThanEqual(3, "message");
        $this->assertFalse($validator->Validate(2));
    }

    /**
     * @test
     */
    public function LargerThanEqualSucceedsOnHigher()
    {
        $validator = new \Form\model\validation\LargerThanEqual(3, "message");
        $this->assertTrue($validator->Validate(4));
    }


}
