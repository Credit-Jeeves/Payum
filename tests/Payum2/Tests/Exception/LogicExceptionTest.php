<?php
namespace Payum2\Tests\Exception;

use Payum2\Exception\LogicException;

class LogicExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldImplementExceptionInterface()
    {
        $rc = new \ReflectionClass('Payum2\Exception\LogicException');
        
        $this->assertTrue($rc->implementsInterface('Payum2\Exception\ExceptionInterface'));
    }

    /**
     * @test
     */
    public function shouldBeSubClassOfRuntimeException()
    {
        $rc = new \ReflectionClass('Payum2\Exception\LogicException');

        $this->assertTrue($rc->isSubclassOf('LogicException'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithoutAnyArguments()
    {
        new LogicException;
    }
}
