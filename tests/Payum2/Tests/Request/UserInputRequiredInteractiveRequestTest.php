<?php
namespace Payum2\Tests\Request;

use Payum2\Request\UserInputRequiredInteractiveRequest;

class UserInputRequiredInteractiveRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldImplementInteractiveRequestInterface()
    {
        $rc = new \ReflectionClass('Payum2\Request\UserInputRequiredInteractiveRequest');

        $this->assertTrue($rc->implementsInterface('Payum2\Request\InteractiveRequestInterface'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithModelAndRequiredFieldsAsArgument()
    {
        new UserInputRequiredInteractiveRequest(array(
            'a_field',
        ));
    }

    /**
     * @test
     */
    public function shouldAllowGetRequiredFieldsSetInConstructor()
    {
        $expectedRequiredFields = array(
            'a_field',
        );

        $request = new UserInputRequiredInteractiveRequest($expectedRequiredFields);

        $this->assertEquals($expectedRequiredFields, $request->getRequiredFields());
    }
}