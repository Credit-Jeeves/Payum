<?php
namespace Payum2\Tests\Exception;

use Payum2\Exception\RuntimeException;

class RuntimeExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldImplementExceptionInterface()
    {
        $rc = new \ReflectionClass('Payum2\Exception\RuntimeException');
        
        $this->assertTrue($rc->implementsInterface('Payum2\Exception\ExceptionInterface'));
    }

    /**
     * @test
     */
    public function shouldBeSubClassOfRuntimeException()
    {
        $rc = new \ReflectionClass('Payum2\Exception\RuntimeException');

        $this->assertTrue($rc->isSubclassOf('RuntimeException'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithoutAnyArguments()
    {
        new RuntimeException;
    }
}
