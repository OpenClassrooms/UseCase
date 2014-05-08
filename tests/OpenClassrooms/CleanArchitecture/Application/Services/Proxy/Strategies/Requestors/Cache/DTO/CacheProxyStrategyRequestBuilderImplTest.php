<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Cache\DTO;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Cache\DTO\CacheProxyStrategyRequestBuilderImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheProxyStrategyRequestBuilderImplTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Cache\Exceptions\CacheIdMustBeDefinedException
     */
    public function Build_ThrowsException()
    {
        $builder = new CacheProxyStrategyRequestBuilderImpl();
        $builder
            ->create()
            ->build();
    }
}
