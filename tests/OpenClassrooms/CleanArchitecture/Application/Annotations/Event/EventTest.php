<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Annotations\Event;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Name MUST be defined
     */
    public function WithoutName_ThrowException()
    {
        $class = new \ReflectionClass(new EventClassDummy());
        $this->reader->getMethodAnnotation($class->getMethod('withoutName'), 'event');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Method "invalid method" is not allowed. Allowed: pre, post and onException
     */
    public function InvalidMethod_ThrowException()
    {
        $class = new \ReflectionClass(new EventClassDummy());
        $this->reader->getMethodAnnotation($class->getMethod('invalidMethod'), 'event');
    }

    protected function setUp()
    {
        $this->reader = new AnnotationReader();
    }

}
