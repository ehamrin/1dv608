<?php


namespace Form;


require_once dirname(__DIR__) . '/src/Form/controller/FormController.php';

class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function LargerThanEqualValidator()
    {
        $base = 3;
        $validator = new \Form\model\validation\LargerThanEqual($base, "message");

        $this->assertTrue($validator->Validate(3), "3 is equal to {$base} and should pass");
        $this->assertFalse($validator->Validate(2), "2 is less than {$base} and should fail");
        $this->assertTrue($validator->Validate(4), "4 is larger than {$base} and should pass");

        $this->assertNotTrue($validator->Validate("string"), "A string should not pass");
        $this->assertTrue($validator->Validate("4"), "A string that can be interpreted as an int should pass");
        $this->assertNotTrue($validator->Validate("5s"), "A string should not pass with numeric and alpha characters should fail");
    }

    /**
     * @test
     */
    public function LargerThanValidator()
    {
        $base = 3;
        $validator = new \Form\model\validation\LargerThan(3, "message");

        $this->assertFalse($validator->Validate(3), "3 is equal to {$base} and should fail");
        $this->assertFalse($validator->Validate(2), "2 is less than {$base} and should fail");
        $this->assertTrue($validator->Validate(4), "4 is larger than {$base} and should pass");

        $this->assertNotTrue($validator->Validate("string"), "A string should not pass");
        $this->assertTrue($validator->Validate("4"), "A string that can be interpreted as an int should pass");
        $this->assertNotTrue($validator->Validate("5s"), "A string should not pass with numeric and alpha characters should fail");
    }

    /**
     * @test
     */
    public function LessThanValidator()
    {
        $base = 3;
        $validator = new \Form\model\validation\LessThan(3, "message");

        $this->assertFalse($validator->Validate(3), "3 is equal to {$base} and should fail");
        $this->assertTrue($validator->Validate(2), "2 is less than {$base} and should pass");
        $this->assertFalse($validator->Validate(4), "4 is larger than {$base} and should fail");

        $this->assertNotTrue($validator->Validate("string"), "A string should not pass");
        $this->assertTrue($validator->Validate("2"), "A string that can be interpreted as an int should pass");
        $this->assertNotTrue($validator->Validate("2s"), "A string should not pass with numeric and alpha characters should fail");
    }

    /**
     * @test
     */
    public function LessrThanEqualValidator()
    {
        $base = 3;
        $validator = new \Form\model\validation\LessThanEqual($base, "message");

        $this->assertTrue($validator->Validate(3), "3 is equal to {$base} and should pass");
        $this->assertTrue($validator->Validate(2), "2 is less than {$base} and should pass");
        $this->assertFalse($validator->Validate(4), "4 is larger than {$base} and should fail");

        $this->assertFalse($validator->Validate("string"), "A string should not pass");
        $this->assertTrue($validator->Validate("2"), "A string that can be interpreted as an int should pass");
        $this->assertNotTrue($validator->Validate("2s"), "A string should not pass with numeric and alpha characters should fail");

    }

    /**
     * @test
     */
    public function RequiredValidator()
    {
        $validator = new \Form\model\validation\Required("message");
        $this->assertFalse($validator->Validate(""), "Empty string should fail");
        $this->assertTrue($validator->Validate("data"), 'String with "data" should pass');
        $this->assertFalse($validator->Validate(" "), "String with whitespaces should fail");
    }

    /**
     * @test
     */
    public function MaxLengthValidator()
    {
        $validator = new \Form\model\validation\MaxLength(10, "message");
        $this->assertFalse($validator->Validate("abcdefghijk"), 'String with "abcdefghijk" (11 characters) should fail Max 10 characters');
        $this->assertTrue($validator->Validate("abcdefghij"), 'String with "abcdefghij" (10 characters) should pass Max 10 characters');
        $this->assertTrue($validator->Validate("abcdefg"), 'String with "abcdefg" (7 characters) should pass Max 10 characters');

    }

    /**
     * @test     */
    public function MinLengthValidator()
    {
        $validator = new \Form\model\validation\MinLength(10, "message");
        $this->assertFalse($validator->Validate(""), 'Empty string should fail');
        $this->assertTrue($validator->Validate("abcdefghijk"), 'String with "abcdefghijk" (11 characters) should pass Min 10 characters');
        $this->assertTrue($validator->Validate("abcdefghij"), 'String with "abcdefghij" (10 characters) should fail Min 10 characters');
        $this->assertFalse($validator->Validate("abcdefg"), 'String with "abcdefg" (7 characters) should fail Min 10 characters');

    }

}