<?php


namespace Form;

use \PHPUnit_Framework_TestCase;

require_once dirname(__DIR__) . '/../src/Form/controller/FormController.php';

class RequiredValidator extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function RequiredInputWithoutDataFails()
    {
        $validator = new \Form\model\validation\Required("message");
        $this->assertFalse($validator->Validate(""));
    }

    /**
     * @test
     */
    public function RequiredInputWithDataSucceeds()
    {
        $validator = new \Form\model\validation\Required("message");
        $this->assertTrue($validator->Validate("data"));

    }

    /**
     * @test
     */
    public function RequiredInputWithWhitespaceFails()
    {
        $validator = new \Form\model\validation\Required("message");
        $this->assertFalse($validator->Validate(" "));
    }


}
