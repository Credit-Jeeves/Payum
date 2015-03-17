<?php
namespace Payum2\Action;

use Payum2\PaymentAwareInterface;
use Payum2\PaymentInterface;

abstract class PaymentAwareAction implements ActionInterface, PaymentAwareInterface
{
    /**
     * @var PaymentInterface
     */
    protected $payment;

    /**
     * {@inheritdoc}
     */
    public function setPayment(PaymentInterface $payment)
    {
        $this->payment = $payment;
    }
}