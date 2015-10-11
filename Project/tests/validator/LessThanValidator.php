<?php


namespace Form;

use \PHPUnit_Framework_TestCase;

require_once dirname(__DIR__) . '/../src/Form/controller/FormController.php';

class LessThanValidator extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function LessThanFailsOnEqual()
    {
        $validator = new \Form\model\validation\LessThan(3, "message");
        $this->assertFalse($validator->Validate(3));
    }

    /**
     * @test
     */
    public function LessThanSucceedsOnLower()
    {
        $validator = new \Form\model\validation\LessThan(3, "message");
        $this->assertTrue($validator->Validate(2));
    }

    /**
     * @test
     */
    public function LessThanFailsOnHigher()
    {
        $validator = new \Form\model\validation\LessThan(3, "message");
        $this->assertFalse($validator->Validate(4));
    }



}
