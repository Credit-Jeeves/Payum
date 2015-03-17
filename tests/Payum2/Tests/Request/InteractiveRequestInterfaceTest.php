<?php
namespace Payum2\Tests\Request;

class InteractiveRequestInterfaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldImplementExceptionInterface()
    {
        $rc = new \ReflectionClass('Payum2\Request\InteractiveRequestInterface');

        $this->assertTrue($rc->implementsInterface('Payum2\Exception\ExceptionInterface'));
    }
}