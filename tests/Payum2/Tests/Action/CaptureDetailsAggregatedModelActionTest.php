<?php
namespace Payum2\Tests\Action;

use Payum2\Action\CaptureDetailsAggregatedModelAction;
use Payum2\Request\CaptureRequest;

class CaptureDetailsAggregatedModelActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeSubClassOfPaymentAwareAction()
    {
        $rc = new \ReflectionClass('Payum2\Action\CaptureDetailsAggregatedModelAction');
        
        $this->assertTrue($rc->isSubclassOf('Payum2\Action\PaymentAwareAction'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithoutAnyArguments()   
    {
        new CaptureDetailsAggregatedModelAction();
    }

    /**
     * @test
     */
    public function shouldSupportCaptureRequestWithPaymentInstructionAggregateAsModel()
    {
        $modelMock = $this->getMock('Payum2\Model\DetailsAggregateInterface');
        $modelMock
            ->expects($this->atLeastOnce())
            ->method('getDetails')
            ->will($this->returnValue(new \stdClass))
        ;
        
        $action = new CaptureDetailsAggregatedModelAction();

        $this->assertTrue($action->supports(new CaptureRequest($modelMock)));
    }

    /**
     * @test
     */
    public function shouldNotSupportCaptureRequestWithPaymentInstructionAggregateAsModelIfInstructionNotSet()
    {
        $modelMock = $this->getMock('Payum2\Model\DetailsAggregateInterface');
        $modelMock
            ->expects($this->atLeastOnce())
            ->method('getDetails')
            ->will($this->returnValue(null))
        ;

        $action = new CaptureDetailsAggregatedModelAction();

        $this->assertFalse($action->supports(new CaptureRequest($modelMock)));
    }

    /**
     * @test
     */
    public function shouldNotSupportNotCaptureRequest()
    {
        $action = new CaptureDetailsAggregatedModelAction();
        
        $request = new \stdClass();

        $this->assertFalse($action->supports($request));
    }

    /**
     * @test
     */
    public function shouldNotSupportCaptureRequestAndNotPaymentInstructionAggregateAsModel()
    {
        $action = new CaptureDetailsAggregatedModelAction();
        
        $request = new CaptureRequest(new \stdClass());
        
        $this->assertFalse($action->supports($request));
    }

    /**
     * @test
     * 
     * @expectedException \Payum2\Exception\RequestNotSupportedException
     */
    public function throwIfNotSupportedRequestGivenAsArgumentForExecute()
    {
        $action = new CaptureDetailsAggregatedModelAction();

        $action->execute(new \stdClass());
    }

    /**
     * @test
     */
    public function shouldCallPaymentExecuteWithCaptureRequestAndInstructionSetAsModel()
    {
        $expectedInstruction = new \stdClass;
        
        $testCase = $this;
        
        $paymentMock = $this->createPaymentMock();
        $paymentMock
            ->expects($this->once())
            ->method('execute')
            ->with($this->isInstanceOf('Payum2\Request\CaptureRequest'))
            ->will($this->returnCallback(function($request) use ($expectedInstruction, $testCase) {
                $testCase->assertSame($expectedInstruction, $request->getModel());
            }))
        ;
        
        $action = new CaptureDetailsAggregatedModelAction();
        $action->setPayment($paymentMock);

        $modelMock = $this->getMock('Payum2\Model\DetailsAggregateInterface');
        $modelMock
            ->expects($this->atLeastOnce())
            ->method('getDetails')
            ->will($this->returnValue($expectedInstruction))
        ;
        
        $action->execute(new CaptureRequest($modelMock));
    }
    
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Payum2\PaymentInterface
     */
    protected function createPaymentMock()
    {
        return $this->getMock('Payum2\PaymentInterface');
    }
}
