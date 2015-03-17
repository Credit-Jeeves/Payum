<?php
namespace Payum2\Tests\Functional\Extension;

use Payum2\Action\PaymentAwareAction;
use Payum2\Extension\EndlessCycleDetectorExtension;
use Payum2\Payment;

class EndlessCycleDetectorExtensionTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @test
     * 
     * @expectedException \Payum2\Exception\LogicException
     * @expectedExceptionMessage Possible endless cycle detected. ::onPreExecute was called 10 times before reach the limit.
     */
    public function throwCycleRequestIfActionCallsMoreThenLimitAllows()
    {
        $cycledRequest = new \stdClass();

        $action = new RequireOtherRequestAction;
        $action->setSupportedRequest($cycledRequest);
        $action->setRequiredRequest($cycledRequest);

        $payment = new Payment();
        $payment->addExtension(new EndlessCycleDetectorExtension($limit = 10));
        $payment->addAction($action);

        $payment->execute($cycledRequest);
    }
}

class RequireOtherRequestAction extends PaymentAwareAction
{
    protected $supportedRequest;

    protected $requiredRequest;

    /**
     * @param $request
     */
    public function setSupportedRequest($request)
    {
        $this->supportedRequest = $request;
    }

    /**
     * @param $request
     */
    public function setRequiredRequest($request)
    {
        $this->requiredRequest = $request;
    }

    public function execute($request)
    {
        $this->payment->execute($this->requiredRequest);
    }

    public function supports($request)
    {
        return $this->supportedRequest === $request;
    }
}