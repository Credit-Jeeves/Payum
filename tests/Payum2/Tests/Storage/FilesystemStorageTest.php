<?php
namespace Payum2\Tests\Storage;

use Payum2\Examples\Model\TestModel;
use \Payum2\Storage\FilesystemStorage;

class FilesystemStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldImplementStorageInterface()
    {
        $rc = new \ReflectionClass('Payum2\Storage\FilesystemStorage');
        
        $this->assertTrue($rc->implementsInterface('Payum2\Storage\StorageInterface'));
    }

    /**
     * @test
     */
    public function couldBeConstructedWithStorageDirModelClassAndIdPropertyArguments()
    {
        new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );
    }

    /**
     * @test
     */
    public function shouldCreateInstanceOfModelClassGivenInConstructor()
    {
        $expectedModelClass = 'Payum2\Examples\Model\TestModel';
        
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            $expectedModelClass,
            'id'
        );
        
        $model = $storage->createModel();
        
        $this->assertInstanceOf($expectedModelClass, $model);
        $this->assertNull($model->getId());
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfSupportedModelGiven()
    {
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );
        
        $this->assertTrue($storage->supportModel(new TestModel));
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfSupportedModelClassGiven()
    {
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );

        $this->assertTrue($storage->supportModel('Payum2\Examples\Model\TestModel'));
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfNotSupportedModelGiven()
    {
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );

        $this->assertFalse($storage->supportModel(new \stdClass));
    }

    /**
     * @test
     */
    public function shouldUpdateModelAndSetIdToModel()
    {
        $expectedModelClass = 'Payum2\Examples\Model\TestModel';

        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            $expectedModelClass,
            'id'
        );

        $model = $storage->createModel();
        
        $storage->updateModel($model);

        $this->assertInstanceOf($expectedModelClass, $model);
        $this->assertNotEmpty($model->getId());
    }

    /**
     * @test
     */
    public function shouldKeepIdTheSameOnSeveralUpdates()
    {
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );

        $model = $storage->createModel();

        $storage->updateModel($model);
        $firstId = $model->getId();

        $storage->updateModel($model);
        $secondId = $model->getId();

        $this->assertSame($firstId, $secondId);
    }

    /**
     * @test
     */
    public function shouldCreateFileWithModelInfoInStorageDirOnUpdateModel()
    {
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );

        $model = $storage->createModel();
        $storage->updateModel($model);
        
        $this->assertFileExists(sys_get_temp_dir().'/payum-model-'.$model->getId());
    }

    /**
     * @test
     */
    public function shouldGenerateDifferentIdsForDifferentModels()
    {
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );

        $modelOne = $storage->createModel();
        $storage->updateModel($modelOne);

        $modelTwo = $storage->createModel();
        $storage->updateModel($modelTwo);

        $this->assertNotSame($modelOne->getId(), $modelTwo->getId());
    }

    /**
     * @test
     * 
     * @expectedException \Payum2\Exception\InvalidArgumentException
     * @expectedExceptionMessage Invalid model given. Should be instance of Payum2\Examples\Model\TestModel
     */
    public function throwIfTryUpdateNotSupportedModel()
    {
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );
        
        $notSupportedModel = new \stdClass;
        
        //guard
        $this->assertFalse($storage->supportModel($notSupportedModel));
        
        $storage->updateModel($notSupportedModel);
    }

    /**
     * @test
     *
     * @expectedException \Payum2\Exception\InvalidArgumentException
     * @expectedExceptionMessage Invalid model given. Should be instance of Payum2\Examples\Model\TestModel
     */
    public function throwIfTryGetIdentifierOfNotSupportedModel()
    {
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );

        $notSupportedModel = new \stdClass;

        //guard
        $this->assertFalse($storage->supportModel($notSupportedModel));

        $storage->getIdentificator($notSupportedModel);
    }


    /**
     * @test
     *
     * @expectedException \Payum2\Exception\LogicException
     * @expectedExceptionMessage The model must be persisted before usage of this method
     */
    public function throwIfTryGetIdentifierOfNotPersistedModel()
    {
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );

        $model = $storage->createModel();

        //guard
        $this->assertNull($model->getId());

        $storage->getIdentificator($model);
    }

    /**
     * @test
     */
    public function shouldAllowGetModelIdentificator()
    {
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );

        $model = $storage->createModel();

        $storage->updateModel($model);
        $firstId = $model->getId();

        $storage->updateModel($model);
        $secondId = $model->getId();

        $this->assertSame($firstId, $secondId);
    }

    /**
     * @test
     */
    public function shouldFindModelById()
    {
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );
        
        $model = $storage->createModel();
        $storage->updateModel($model);

        
        //guard
        $this->assertNotEmpty($model->getId());
        
        $identificator = $storage->getIdentificator($model);

        $this->assertInstanceOf('Payum2\Storage\Identificator', $identificator);
        $this->assertEquals(get_class($model), $identificator->getClass());
        $this->assertEquals($model->getId(), $identificator->getId());
    }

    /**
     * @test
     */
    public function shouldStoreInfoBetweenUpdateAndFind()
    {
        $storage = new FilesystemStorage(
            sys_get_temp_dir(),
            'Payum2\Examples\Model\TestModel',
            'id'
        );

        $model = $storage->createModel();
        $model->setPrice($expectedPrice = 123);
        $model->setCurrency($expectedCurrency = 'FOO');
        
        $storage->updateModel($model);

        $foundModel = $storage->findModelById($model->getId());

        $this->assertNotSame($model, $foundModel);
        $this->assertEquals($expectedPrice, $foundModel->getPrice());
        $this->assertEquals($expectedCurrency, $foundModel->getCurrency());
    }
}
