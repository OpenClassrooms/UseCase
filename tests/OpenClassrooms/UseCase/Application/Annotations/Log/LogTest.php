<?php

namespace OpenClassrooms\Tests\UseCase\Application\Annotations\Log;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class LogTest extends TestCase
{

    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     * @test
     */
    public function InvalidLevel_ThrowException()
    {
        $class = new \ReflectionClass(new LogClassDummy());

        $this->expectException(AnnotationException::class);
        $this->expectExceptionMessage('Level "invalid level" is not a valid PSR level. See Psr\Log\LogLevel.');

        $this->reader->getMethodAnnotation($class->getMethod('invalidLevel'), 'log');
    }

    /**
     * @test
     */
    public function InvalidMethod_ThrowException()
    {
        $class = new \ReflectionClass(new LogClassDummy());

        $this->expectException(AnnotationException::class);
        $this->expectExceptionMessage('Method "invalid method" is not allowed. Allowed: pre, post and onException');

        $this->reader->getMethodAnnotation($class->getMethod('invalidMethod'), 'log');
    }

    protected function setUp(): void
    {
        $this->reader = new AnnotationReader();
    }
}
