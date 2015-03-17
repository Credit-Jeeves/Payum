<?php
namespace Payum2\Tests\Request;

class StatusRequestInterfaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldImplementInteractiveRequestInterface()
    {
        $rc = new \ReflectionClass('Payum2\Request\StatusRequestInterface');

        $this->assertTrue($rc->implementsInterface('Payum2\Request\InteractiveRequestInterface'));
    }

    /**
     * @test
     */
    public function shouldImplementModelRequestInterface()
    {
        $rc = new \ReflectionClass('Payum2\Request\StatusRequestInterface');

        $this->assertTrue($rc->implementsInterface('Payum2\Request\ModelRequestInterface'));
    }
}