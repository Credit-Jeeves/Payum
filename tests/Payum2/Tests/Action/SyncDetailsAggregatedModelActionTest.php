<?php
namespace Payum2\Tests\Action;

use Payum2\Action\SyncDetailsAggregatedModelAction;
use Payum2\Request\SyncRequest;

class SyncDetailsAggregatedModelActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeSubClassOfPaymentAwareAction()
    {
        $rc = new \ReflectionClass('Payum2\Action\SyncDetailsAggregatedModelAction');
        
        $this->assertTrue($rc->isSubclassOf('Payum2\Action\PaymentAwareAction'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithoutAnyArguments()   
    {
        new SyncDetailsAggregatedModelAction();
    }

    /**
     * @test
     */
    public function shouldSupportSyncRequestWithPaymentInstructionAggregateAsModel()
    {
        $modelMock = $this->getMock('Payum2\Model\DetailsAggregateInterface');
        $modelMock
            ->expects($this->atLeastOnce())
            ->method('getDetails')
            ->will($this->returnValue(new \stdClass))
        ;
        
        $action = new SyncDetailsAggregatedModelAction();

        $this->assertTrue($action->supports(new SyncRequest($modelMock)));
    }

    /**
     * @test
     */
    public function shouldNotSupportSyncRequestWithPaymentInstructionAggregateAsModelIfInstructionNotSet()
    {
        $modelMock = $this->getMock('Payum2\Model\DetailsAggregateInterface');
        $modelMock
            ->expects($this->atLeastOnce())
            ->method('getDetails')
            ->will($this->returnValue(null))
        ;

        $action = new SyncDetailsAggregatedModelAction();

        $this->assertFalse($action->supports(new SyncRequest($modelMock)));
    }

    /**
     * @test
     */
    public function shouldNotSupportNotSyncRequest()
    {
        $action = new SyncDetailsAggregatedModelAction();
        
        $request = new \stdClass();

        $this->assertFalse($action->supports($request));
    }

    /**
     * @test
     */
    public function shouldNotSupportSyncRequestAndNotPaymentInstructionAggregateAsModel()
    {
        $action = new SyncDetailsAggregatedModelAction();
        
        $request = new SyncRequest(new \stdClass());
        
        $this->assertFalse($action->supports($request));
    }

    /**
     * @test
     * 
     * @expectedException \Payum2\Exception\RequestNotSupportedException
     */
    public function throwIfNotSupportedRequestGivenAsArgumentForExecute()
    {
        $action = new SyncDetailsAggregatedModelAction();

        $action->execute(new \stdClass());
    }

    /**
     * @test
     */
    public function shouldCallPaymentExecuteWithSyncRequestAndInstructionSetAsModel()
    {
        $expectedInstruction = new \stdClass;

        $testCase = $this;
        
        $paymentMock = $this->createPaymentMock();
        $paymentMock
            ->expects($this->once())
            ->method('execute')
            ->with($this->isInstanceOf('Payum2\Request\SyncRequest'))
            ->will($this->returnCallback(function($request) use ($expectedInstruction, $testCase) {
                $testCase->assertSame($expectedInstruction, $request->getModel());
            }))
        ;
        
        $action = new SyncDetailsAggregatedModelAction();
        $action->setPayment($paymentMock);

        $modelMock = $this->getMock('Payum2\Model\DetailsAggregateInterface');
        $modelMock
            ->expects($this->atLeastOnce())
            ->method('getDetails')
            ->will($this->returnValue($expectedInstruction))
        ;
        
        $action->execute(new SyncRequest($modelMock));
    }
    
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\Payum2\PaymentInterface
     */
    protected function createPaymentMock()
    {
        return $this->getMock('Payum2\PaymentInterface');
    }
}
