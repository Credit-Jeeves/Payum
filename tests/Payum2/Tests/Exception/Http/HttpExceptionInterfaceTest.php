<?php
namespace Payum2\Tests\Exception\Http;

use Buzz\Message\Request;
use Buzz\Message\Response;

use Payum2\Exception\Http\HttpException;

class HttpExceptionInterfaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldImplementPayumExceptionInterface()
    {
        $rc = new \ReflectionClass('Payum2\Exception\Http\HttpExceptionInterface');
        
        $this->assertTrue($rc->implementsInterface('Payum2\Exception\ExceptionInterface'));
    }

    /**
     * @test
     */
    public function shouldImplementBuzzExceptionInterface()
    {
        $rc = new \ReflectionClass('Payum2\Exception\Http\HttpExceptionInterface');

        $this->assertTrue($rc->implementsInterface('Buzz\Exception\ExceptionInterface'));
    }
}
