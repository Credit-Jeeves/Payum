<?php
namespace Payum2\Tests\Request;

use Payum2\Request\NotifyTokenizedDetailsRequest;
use Payum2\Model\TokenizedDetails;

class NotifyTokenizedDetailsRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldImplementModelRequestInterface()
    {
        $rc = new \ReflectionClass('Payum2\Request\NotifyTokenizedDetailsRequest');

        $this->assertTrue($rc->implementsInterface('Payum2\Request\ModelRequestInterface'));
    }

    /**
     * @test
     */
    public function shouldBeSubClassOfNotifyRequest()
    {
        $rc = new \ReflectionClass('Payum2\Request\NotifyTokenizedDetailsRequest');

        $this->assertTrue($rc->isSubclassOf('Payum2\Request\NotifyRequest'));
    }


    /**
     * @test
     */
    public function couldBeConstructedWithNotificationAndTokenizedDetails()
    {
        new NotifyTokenizedDetailsRequest($notification = array(), new TokenizedDetails);
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

        $request = new NotifyTokenizedDetailsRequest($expectedNotification, new TokenizedDetails);

        $this->assertSame($expectedNotification, $request->getNotification());
    }

    /**
     * @test
     */
    public function shouldAllowGetTokenizedDetailsSetInConstructor()
    {
        $expectedTokenizedDetails = new TokenizedDetails;
        
        $request = new NotifyTokenizedDetailsRequest($notification = array(), $expectedTokenizedDetails);
        
        $this->assertSame($expectedTokenizedDetails, $request->getTokenizedDetails());
        $this->assertSame($expectedTokenizedDetails, $request->getModel());
    }

    /**
     * @test
     */
    public function shouldAllowSetModelAndKeepTokenizedDetailsSame()
    {
        $tokenizedDetails = new TokenizedDetails;

        $request = new NotifyTokenizedDetailsRequest($notification = array(), $tokenizedDetails);

        //guard
        $this->assertSame($tokenizedDetails, $request->getTokenizedDetails());
        $this->assertSame($tokenizedDetails, $request->getModel());

        $newModel = new \stdClass;
            
        $request->setModel($newModel);

        $this->assertSame($tokenizedDetails, $request->getTokenizedDetails());
        $this->assertSame($newModel, $request->getModel());
    }
}