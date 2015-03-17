<?php
namespace Payum2\Tests\Exception;

use Payum2\Exception\UnsupportedApiException;

class UnsupportedApiExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeSubClassOfInvalidArgumentException()
    {
        $rc = new \ReflectionClass('Payum2\Exception\UnsupportedApiException');
        
        $this->assertTrue($rc->isSubclassOf('Payum2\Exception\InvalidArgumentException'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithoutAnyArguments()
    {
        new UnsupportedApiException;
    }
}
