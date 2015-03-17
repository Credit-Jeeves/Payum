<?php
namespace Payum2\Tests\Request;

class BaseInteractiveRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldImplementInteractiveRequestInterface()
    {
        $rc = new \ReflectionClass('Payum2\Request\BaseInteractiveRequest');
        
        $this->assertTrue($rc->implementsInterface('Payum2\Request\InteractiveRequestInterface'));
    }

    /**
     * @test
     */
    public function shouldBeSubClassOfLogicException()
    {
        $rc = new \ReflectionClass('Payum2\Request\BaseInteractiveRequest');

        $this->assertTrue($rc->isSubclassOf('Payum2\Exception\LogicException'));
    }
}