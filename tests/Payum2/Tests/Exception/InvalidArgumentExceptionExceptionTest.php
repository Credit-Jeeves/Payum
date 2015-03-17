<?php
namespace Payum2\Tests\Exception;

use Payum2\Exception\InvalidArgumentException;

class InvalidArgumentExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldImplementExceptionInterface()
    {
        $rc = new \ReflectionClass('Payum2\Exception\InvalidArgumentException');
        
        $this->assertTrue($rc->implementsInterface('Payum2\Exception\ExceptionInterface'));
    }

    /**
     * @test
     */
    public function shouldBeSubClassOfRuntimeException()
    {
        $rc = new \ReflectionClass('Payum2\Exception\InvalidArgumentException');

        $this->assertTrue($rc->isSubclassOf('InvalidArgumentException'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithoutAnyArguments()
    {
        new InvalidArgumentException;
    }
}
