<?php
namespace Payum2\Tests\Functional\Bridge\Doctrine;

use Doctrine\ORM\Tools\SchemaValidator;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

class OrmTest extends BaseOrmTest
{
    /**
     * @return array
     */
    protected function getMetadataDriverImpl()
    {   
        $rootDir = realpath(__DIR__.'/../../../../../../');
        if (false === $rootDir || false === is_dir($rootDir.'/src/Payum2')) {
            throw new \RuntimeException('Cannot gues Payum root dir.');
        }
        
        $driver = new MappingDriverChain;
        
//        $xmlDriver = new SimplifiedXmlDriver(array(
//            $rootDir.'/src/Payum/Bridge/Doctrine/Resources/mapping' => 'Payum2\Bridge\Doctrine\Entity'
//        ));        
//        $driver->addDriver($xmlDriver, 'Payum2\Bridge\Doctrine\Entity');

        $rc = new \ReflectionClass('\Doctrine\ORM\Mapping\Driver\AnnotationDriver');
        AnnotationRegistry::registerFile(dirname($rc->getFileName()) . '/DoctrineAnnotations.php');

        $annotationDriver = new AnnotationDriver(new AnnotationReader(), array(
            $rootDir.'/examples/Payum2/Examples/Entity'
        ));
        $driver->addDriver($annotationDriver, 'Payum2\Examples\Entity');
        
        return $driver;
    }
    
    /**
     * @test
     */
    public function shouldAllSchemasBeValid()
    {   
        $schemaValidator = new SchemaValidator($this->em);
        
        $this->assertEmpty($schemaValidator->validateMapping());
    }
}