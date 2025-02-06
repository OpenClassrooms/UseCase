<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\Strategies\Requestors\Cache\DTO;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Cache\DTO\CacheProxyStrategyRequestBuilderImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Cache\Exceptions\CacheIdMustBeDefinedException;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class CacheProxyStrategyRequestBuilderImplTest extends TestCase
{
    /**
     * @test
     */
    public function Build_ThrowsException()
    {
        $builder = new CacheProxyStrategyRequestBuilderImpl();

        $this->expectException(CacheIdMustBeDefinedException::class);

        $builder
            ->create()
            ->build();
    }
}
