<?php

namespace OpenClassrooms\Tests\UseCase\Application\Annotations\Security;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class SecurityTest extends TestCase
{

    /**
     * @var AnnotationReader
     */
    private $reader;

    /**
     * @test
     */
    public function WithoutRole_ThrowException()
    {
        $class = new \ReflectionClass(new SecurityClassDummy());

        $this->expectException(AnnotationException::class);
        $this->expectExceptionMessage('Roles MUST be defined');

        $this->reader->getMethodAnnotation($class->getMethod('method'), 'security');
    }

    protected function setUp(): void
    {
        $this->reader = new AnnotationReader();
    }
}
