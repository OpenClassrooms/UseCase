<?php

namespace OpenClassrooms\Tests\UseCase\Application\Annotations\Log;

use Doctrine\Common\Annotations\AnnotationReader;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class LogTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Level "invalid level" is not a valid PSR level. See Psr\Log\LogLevel.
     */
    public function InvalidLevel_ThrowException()
    {
        $class = new \ReflectionClass(new LogClassDummy());
        $this->reader->getMethodAnnotation($class->getMethod('invalidLevel'), 'log');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Method "invalid method" is not allowed. Allowed: pre, post and onException
     */
    public function InvalidMethod_ThrowException()
    {
        $class = new \ReflectionClass(new LogClassDummy());
        $this->reader->getMethodAnnotation($class->getMethod('invalidMethod'), 'log');
    }

    protected function setUp()
    {
        $this->reader = new AnnotationReader();
    }
}
