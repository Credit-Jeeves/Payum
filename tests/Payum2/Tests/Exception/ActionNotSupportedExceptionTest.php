<?php
namespace Payum2\Tests\Exception;

use Payum2\Exception\RequestNotSupportedException;

class RequestNotSupportedExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeSubClassOfInvalidArgumentException()
    {
        $rc = new \ReflectionClass('Payum2\Exception\RequestNotSupportedException');
        
        $this->assertTrue($rc->isSubclassOf('Payum2\Exception\InvalidArgumentException'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithoutAnyArguments()
    {
        new RequestNotSupportedException;
    }

    /**
     * @test
     */
    public function shouldCreateWithNoneObjectRequest()
    {
        $exception = RequestNotSupportedException::create('anRequest');
        
        $this->assertInstanceOf('Payum2\Exception\RequestNotSupportedException', $exception);
        $this->assertEquals('Request string is not supported.', $exception->getMessage());
    }

    /**
     * @test
     */
    public function shouldCreateWithObjectRequest()
    {
        $exception = RequestNotSupportedException::create(new \stdClass());

        $this->assertInstanceOf('Payum2\Exception\RequestNotSupportedException', $exception);
        $this->assertEquals('Request stdClass is not supported.', $exception->getMessage());
    }

    /**
     * @test
     */
    public function shouldCreateWithActionAndStringRequest()
    {
        $action = $this->getMock('Payum2\Action\ActionInterface', array(), array(), 'Mock_Action12');
        
        $exception = RequestNotSupportedException::createActionNotSupported($action, 'anRequest');

        $this->assertInstanceOf('Payum2\Exception\RequestNotSupportedException', $exception);
        $this->assertEquals(
            'Action Mock_Action12 is not supported the request string.', 
            $exception->getMessage()
        );
    }

    /**
     * @test
     */
    public function shouldCreateWithActionAndObjectRequest()
    {
        $action = $this->getMock('Payum2\Action\ActionInterface', array(), array(), 'Mock_Action24');

        $exception = RequestNotSupportedException::createActionNotSupported($action, new \stdClass());

        $this->assertInstanceOf('Payum2\Exception\RequestNotSupportedException', $exception);
        $this->assertEquals(
            'Action Mock_Action24 is not supported the request stdClass.',
            $exception->getMessage()
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Payum2\Action\ActionInterface
     */
    protected function createActionMock()
    {
        return $this->getMock('Payum2\Action\ActionInterface');
    }
}
