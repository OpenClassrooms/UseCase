<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Annotations\Security;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class SecurityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Roles MUST be defined
     */
    public function WithoutRole_ThrowException()
    {
        $class = new \ReflectionClass(new SecurityClassDummy2());
        $this->reader->getMethodAnnotation($class->getMethod('method'), 'security');
    }

    protected function setUp()
    {
        $this->reader = new AnnotationReader();
    }

}
