<?php
namespace Payum2\Tests\Request;

use Payum2\Request\NotifyRequest;

class NotifyRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function couldBeConstructedWithNotificationAsFirstArgument()
    {
        new NotifyRequest(array(
            'foo' => 'aFoo'
        ));
    }

    /**
     * @test
     */
    public function shouldAllowGetNotificationSetInConstructor()
    {
        $expectedNotification = array(
            'foo' => 'aFooValue',
            'bar' => 'aBarValue'
        );
        
        $request = new NotifyRequest($expectedNotification);
        
        $this->assertSame($expectedNotification, $request->getNotification());
    }
}