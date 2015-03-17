<?php
namespace Payum2\Registry;

use Payum2\PaymentInterface;
use Payum2\Exception\InvalidArgumentException;

interface PaymentRegistryInterface 
{
    /**
     * @return string
     */
    function getDefaultPaymentName();

    /**
     * @param string|null $name
     * 
     * @throws InvalidArgumentException if payment with such name not exist
     * 
     * @return PaymentInterface
     */
    function getPayment($name = null);
}