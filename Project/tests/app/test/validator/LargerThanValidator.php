<?php


namespace Form;

use \PHPUnit_Framework_TestCase;

class LargerThanValidator extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function LargerThanFailsOnEqual()
    {
        $validator = new \Form\model\validation\LargerThan(3, "message");
        $this->assertFalse($validator->Validate(3));
    }

    /**
     * @test
     */
    public function LargerThanFailsOnLower()
    {
        $validator = new \Form\model\validation\LargerThan(3, "message");
        $this->assertFalse($validator->Validate(2));
    }

    /**
     * @test
     */
    public function LargerThanSucceedsOnHigher()
    {
        $validator = new \Form\model\validation\LargerThan(3, "message");
        $this->assertTrue($validator->Validate(4));
    }



}
