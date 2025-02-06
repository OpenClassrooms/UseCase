<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\Strategies\Requestors;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Exceptions\UnSupportedAnnotationException;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\ProxyStrategyBagFactoryImpl;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class ProxyStrategyBagFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function UnsupportedAnnotation_Make_ThrowException()
    {
        $factory = new ProxyStrategyBagFactoryImpl();
        $this->expectException(UnSupportedAnnotationException::class);

        $factory->make('unsupported annotation');
    }
}
