<?php
namespace Payum2;

interface PaymentAwareInterface
{
    /**
     * @param \Payum2\PaymentInterface $payment
     *
     * @return void
     */
    function setPayment(PaymentInterface $payment);
}