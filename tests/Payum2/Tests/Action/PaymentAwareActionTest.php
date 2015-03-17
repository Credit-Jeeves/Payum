<?php
namespace Payum2\Tests\Action;

class PaymentAwareActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldImplementActionInterface()
    {
        $rc = new \ReflectionClass('Payum2\Action\PaymentAwareAction');
        
        $this->assertTrue($rc->implementsInterface('Payum2\Action\ActionInterface'));
    }

    /**
     * @test
     */
    public function shouldImplementPaymentAwareInterface()
    {
        $rc = new \ReflectionClass('Payum2\Action\PaymentAwareAction');

        $this->assertTrue($rc->implementsInterface('Payum2\PaymentAwareInterface'));
    }

    /**
     * @test
     */
    public function shouldSetPaymentToProperty()
    {
        $payment = $this->getMock('Payum2\PaymentInterface');
        
        $action = $this->getMockForAbstractClass('Payum2\Action\PaymentAwareAction');
        
        $action->setPayment($payment);
        
        $this->assertAttributeSame($payment, 'payment', $action);
    }
}