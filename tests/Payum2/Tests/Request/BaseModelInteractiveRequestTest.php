<?php
namespace Payum2\Tests\Request;

class BaseModelInteractiveRequestTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @test
     */
    public function shouldImplementInteractiveRequestInterface()
    {
        $rc = new \ReflectionClass('Payum2\Request\BaseModelInteractiveRequest');

        $this->assertTrue($rc->implementsInterface('Payum2\Request\InteractiveRequestInterface'));
    }

    /**
     * @test
     */
    public function shouldImplementModelRequestInterface()
    {
        $rc = new \ReflectionClass('Payum2\Request\BaseModelInteractiveRequest');

        $this->assertTrue($rc->implementsInterface('Payum2\Request\ModelRequestInterface'));
    }

    /**
     * @test
     */
    public function shouldBeSubClassOfLogicException()
    {
        $rc = new \ReflectionClass('Payum2\Request\BaseModelInteractiveRequest');

        $this->assertTrue($rc->isSubclassOf('Payum2\Exception\LogicException'));
    }
    
    /**
     * @test
     */
    public function shouldBeAbstractClass()
    {
        $rc = new \ReflectionClass('Payum2\Request\BaseModelInteractiveRequest');
        
        $this->assertTrue($rc->isAbstract());
    }

    public static function provideDifferentPhpTypes()
    {
        return array(
            'object' => array(new \stdClass()),
            'int' => array(5),
            'float' => array(5.5),
            'string' => array('foo'),
            'boolean' => array(false),
            'resource' => array(tmpfile())
        );
    }

    /**
     * @test
     * 
     * @dataProvider provideDifferentPhpTypes
     */
    public function couldBeConstructedWithModelOfAnyType($phpType)
    {
        $this->getMockForAbstractClass('Payum2\Request\BaseModelInteractiveRequest', array($phpType));
    }

    /**
     * @test
     *
     * @dataProvider provideDifferentPhpTypes
     */
    public function shouldAllowSetModelAndGetIt($phpType)
    {
        $request = $this->getMockForAbstractClass('Payum2\Request\BaseModelInteractiveRequest', array(123321));

        $request->setModel($phpType);
        
        $this->assertEquals($phpType, $request->getModel());
    }

    /**
     * @test
     *
     * @dataProvider provideDifferentPhpTypes
     */
    public function shouldAllowGetModelSetInConstructor($phpType)
    {
        $request = $this->getMockForAbstractClass('Payum2\Request\BaseModelInteractiveRequest', array($phpType));
        
        $this->assertEquals($phpType, $request->getModel());
    }

    /**
     * @test
     */
    public function shouldConvertArrayToArrayObjectInConstructor()
    {
        $model = array('foo' => 'bar');
        
        $request = $this->getMockForAbstractClass('Payum2\Request\BaseModelInteractiveRequest', array($model));

        $this->assertInstanceOf('ArrayObject', $request->getModel());
        $this->assertEquals($model, (array) $request->getModel());
    }

    /**
     * @test
     */
    public function shouldConvertArrayToArrayObjectSetWithSetter()
    {
        $request = $this->getMockForAbstractClass('Payum2\Request\BaseModelInteractiveRequest', array(123321));

        $model = array('foo' => 'bar');
        
        $request->setModel($model);

        $this->assertInstanceOf('ArrayObject', $request->getModel());
        $this->assertEquals($model, (array) $request->getModel());
    }
}