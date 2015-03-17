<?php
namespace Payum2\Tests\Registry;

class RegistryInterfaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeSubInterfaceOfPaymentRegistryInterface()
    { 
        $rc = new \ReflectionClass('Payum2\Registry\RegistryInterface');
            
        $this->assertTrue($rc->isSubclassOf('Payum2\Registry\PaymentRegistryInterface'));
    }

    /**
     * @test
     */
    public function shouldBeSubInterfaceOfStorageRegistryInterface()
    {
        $rc = new \ReflectionClass('Payum2\Registry\RegistryInterface');

        $this->assertTrue($rc->isSubclassOf('Payum2\Registry\StorageRegistryInterface'));
    }
}