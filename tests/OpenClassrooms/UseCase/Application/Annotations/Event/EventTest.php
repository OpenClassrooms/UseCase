<?php

namespace OpenClassrooms\Tests\UseCase\Application\Annotations\Event;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventTest extends TestCase
{

    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     * @test
     */
    public function InvalidMethod_ThrowException()
    {
        $class = new \ReflectionClass(new EventClassDummy());

        $this->expectException(AnnotationException::class);
        $this->expectExceptionMessage('Method "invalid method" is not allowed. Allowed: pre, post and onException');

        $this->reader->getMethodAnnotation($class->getMethod('invalidMethod'), 'event');
    }

    protected function setUp(): void
    {
        $this->reader = new AnnotationReader();
    }
}
