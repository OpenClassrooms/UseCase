<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Proxies\Strategies\Cache\DTO;

use
    OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies\Cache\DTO\CacheProxyStrategyRequestBuilderImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class CacheProxyStrategyRequestBuilderImplTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors\Cache\Exceptions\CacheIdMustBeSetException
     */
    public function Build_ThrowsException()
    {
        $builder = new CacheProxyStrategyRequestBuilderImpl();
        $builder->build();
    }
}
