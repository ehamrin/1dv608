<?php

namespace Form;

require_once dirname(__DIR__) . '/src/Form/controller/FormController.php';

use \PHPUnit_Framework_TestCase;

class FormControllerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @before
     */
    public static function setupForm()
    {
        \Form\Settings::$UsePRG = FALSE;
    }

    /**
     * @test
     * @expectedException \Form\model\ElementExistsException
     *
     */
    public function SubmittedWithInputWithSameNameThrowsException()
    {
        $form = new \Form\controller\FormController("TestForm");

        $form->AddInput
            (
                new model\input\Text("username"),
                new model\input\Text("username")
            );
    }

    /**
     * @test
     */
    public function SubmittedWithInputWithDifferentNamePasses()
    {
        $form = new \Form\controller\FormController("TestForm");
        $form->AddInput
        (
            new model\input\Text("username"),
            new model\input\Text("username2")
        );
    }

    /**
     * @test
     */
    public function SubmittedWithInputWithNoValidatorPasses()
    {
        $_POST = array('submit' => 'Send');
        $form = new \Form\controller\FormController("TestForm");
        $form->AddInput
        (
            new model\input\Text("username"),
            new model\input\Submit("submit", "Send")
        );
        $this->assertTrue($form->WasSubmitted());
    }

    /**
     * @test
     */
    public function SubmittedWithRequiredInputWithoutDataFails()
    {
        $_POST = array('submit' => 'Send');
        $form = new \Form\controller\FormController("TestForm");
        $form->AddInput
        (
            (new model\input\Text("username"))
                ->SetValidation(new \Form\model\validation\Required("This should fail"))
            ,
            new model\input\Submit("submit", "Send")
        );
        $this->assertFalse($form->WasSubmitted());
    }

    /**
     * @test
     */
    public function SubmittedWithRequiredInputWithDataSucceeds()
    {
        $_POST = array(
            'username' => 'data',
            'submit' => 'Send'
        );

        $form = new \Form\controller\FormController("TestForm");
        $form->AddInput
        (
            (new model\input\Text("username"))
                ->SetValidation(new \Form\model\validation\Required("This should fail"))
            ,
            new model\input\Submit("submit", "Send")
        );
        $this->assertTrue($form->WasSubmitted());
    }

    /**
     * @test
     */
    public function InjectedErrorShowsIfSubmitted()
    {
        $_POST = array(
            'username' => 'data',
            'submit' => 'Send'
        );

        $form = new \Form\controller\FormController("TestForm");
        $form->AddInput
        (
            (new \Form\model\input\Text("username"))
                ->SetValidation(new \Form\model\validation\Required("message"))
            ,
            new \Form\model\input\Submit("submit", "Send")
        );
        $this->assertTrue($form->WasSubmitted(), "Form did not submit");

        $message = "This is an errormessage";
        $form->InjectInputError('username', $message);

        $dom = new \DOMDocument();
        $dom->loadHTML($form->GetView());

        $xpath = new \DOMXpath($dom);
        $result = $xpath->query('//ul[@class="error-messages"]');

        $this->assertTrue($result->length == 1, "Did not find erro message element");
        $this->assertTrue(trim($result->item(0)->textContent) == $message, "Failed asserting that them message matches to one injected");
    }

    /**
     * @test
     */
    public function InjectedErrorDoesNotShowsIfNotSubmitted()
    {
        $form = new \Form\controller\FormController("TestForm");
        $form->AddInput
        (
            (new \Form\model\input\Text("username"))
                ->SetValidation(new \Form\model\validation\Required("message"))
            ,
            new \Form\model\input\Submit("submit", "Send")
        );
        $this->assertFalse($form->WasSubmitted());

        $message = "This is an errormessage";
        $form->InjectInputError('username', $message);

        $dom = new \DOMDocument();
        $dom->loadHTML($form->GetView());

        $xpath = new \DOMXpath($dom);
        $result = $xpath->query('//ul[@class="error-messages"]');

        $this->assertTrue($result->length == 0);
    }



}
