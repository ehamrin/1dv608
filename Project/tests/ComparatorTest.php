<?php

require_once dirname(__DIR__) . '/src/Form/controller/FormController.php';

class ComparatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @class \Form\model\comparator\EqualTo
     * @method Validate
     */
    public function EqualToComparator()
    {
        $base = 3;
        $comparator = new \Form\model\comparator\EqualTo("Input", "Message");

        $this->assertTrue($comparator->Validate(3, $base), "3 is equal to {$base} and should pass");
        $this->assertFalse($comparator->Validate(2, $base), "2 is less than {$base} and should fail");
        $this->assertFalse($comparator->Validate(4, $base), "4 is larger than {$base} and should fail");

    }

    /**
     * @test
     * @class \Form\model\comparator\LargerThan
     * @method Validate
     */
    public function LargerThanComparator()
    {
        $base = 3;
        $comparator = new \Form\model\comparator\LargerThan("input", "message");

        $this->assertFalse($comparator->Validate(3, $base), "3 is equal to {$base} and should fail");
        $this->assertFalse($comparator->Validate(2, $base), "2 is less than {$base} and should fail");
        $this->assertTrue($comparator->Validate(4, $base), "4 is larger than {$base} and should pass");
    }

    /**
     * @test
     * @class \Form\model\comparator\LessThan
     * @method Validate
     */
    public function LessThanComparator()
    {
        $base = 3;
        $comparator = new \Form\model\comparator\LessThan("input", "message");

        $this->assertFalse($comparator->Validate(3, $base), "3 is equal to {$base} and should fail");
        $this->assertTrue($comparator->Validate(2, $base), "2 is less than {$base} and should pass");
        $this->assertFalse($comparator->Validate(4, $base), "4 is larger than {$base} and should fail");

    }



}
