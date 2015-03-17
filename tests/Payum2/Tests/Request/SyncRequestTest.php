<?php
namespace Payum2\Tests\Request;

class SyncRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldBeSubClassOfBaseModelRequest()
    {
        $rc = new \ReflectionClass('Payum2\Request\SyncRequest');

        $this->assertTrue($rc->isSubclassOf('Payum2\Request\BaseModelRequest'));
    }
}