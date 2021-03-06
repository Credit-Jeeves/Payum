<?php
namespace Payum2\Tests\Action;

use Payum2\Action\StatusDetailsAggregatedModelAction;
use Payum2\Request\BinaryMaskStatusRequest;

class StatusDetailsAggregatedModelActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeSubClassOfPaymentAwareAction()
    {
        $rc = new \ReflectionClass('Payum2\Action\StatusDetailsAggregatedModelAction');
        
        $this->assertTrue($rc->isSubclassOf('Payum2\Action\PaymentAwareAction'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithoutAnyArguments()   
    {
        new StatusDetailsAggregatedModelAction();
    }

    /**
     * @test
     */
    public function shouldSupportStatusRequestWithPaymentInstructionAggregateAsModel()
    {
        $modelMock = $this->getMock('Payum2\Model\DetailsAggregateInterface');
        $modelMock
            ->expects($this->atLeastOnce())
            ->method('getDetails')
            ->will($this->returnValue(new \stdClass))
        ;
        
        $action = new StatusDetailsAggregatedModelAction();

        $this->assertTrue($action->supports(new BinaryMaskStatusRequest($modelMock)));
    }

    /**
     * @test
     */
    public function shouldNotSupportStatusRequestWithPaymentInstructionAggregateAsModelIfInstructionNotSet()
    {
        $modelMock = $this->getMock('Payum2\Model\DetailsAggregateInterface');
        $modelMock
            ->expects($this->atLeastOnce())
            ->method('getDetails')
            ->will($this->returnValue(null))
        ;

        $action = new StatusDetailsAggregatedModelAction();

        $this->assertFalse($action->supports(new BinaryMaskStatusRequest($modelMock)));
    }

    /**
     * @test
     */
    public function shouldNotSupportNotStatusRequest()
    {
        $action = new StatusDetailsAggregatedModelAction();
        
        $request = new \stdClass();

        $this->assertFalse($action->supports($request));
    }

    /**
     * @test
     */
    public function shouldNotSupportStatusRequestAndNotPaymentInstructionAggregateAsModel()
    {
        $action = new StatusDetailsAggregatedModelAction();
        
        $request = new BinaryMaskStatusRequest(new \stdClass());
        
        $this->assertFalse($action->supports($request));
    }

    /**
     * @test
     * 
     * @expectedException \Payum2\Exception\RequestNotSupportedException
     */
    public function throwIfNotSupportedRequestGivenAsArgumentForExecute()
    {
        $action = new StatusDetailsAggregatedModelAction();

        $action->execute(new \stdClass());
    }

    /**
     * @test
     */
    public function shouldCallPaymentExecuteWithStatusRequestAndDetailsSetAsModel()
    {
        $expectedPaymentDetails = new \stdClass;

        $modelMock = $this->getMock('Payum2\Model\DetailsAggregateInterface');
        $modelMock
            ->expects($this->atLeastOnce())
            ->method('getDetails')
            ->will($this->returnValue($expectedPaymentDetails))
        ;
        
        $request = new BinaryMaskStatusRequest($modelMock);
        
        $testCase = $this;
        
        $paymentMock = $this->createPaymentMock();
        $paymentMock
            ->expects($this->once())
            ->method('execute')
            ->with($this->identicalTo($request))
            ->will($this->returnCallback(function($request) use ($expectedPaymentDetails, $testCase) {
                $testCase->assertSame($expectedPaymentDetails, $request->getModel());
            }))
        ;
        
        $action = new StatusDetailsAggregatedModelAction();
        $action->setPayment($paymentMock);
        
        $action->execute($request);
        
        $this->assertSame($expectedPaymentDetails, $request->getModel());
    }
    
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Payum2\PaymentInterface
     */
    protected function createPaymentMock()
    {
        return $this->getMock('Payum2\PaymentInterface');
    }
}
