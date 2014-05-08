<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Event\DTO;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Event\DTO\EventProxyStrategyRequestBuilderImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EventProxyStrategyRequestBuilderImplTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Event\Exceptions\EventNameMustBeDefinedException
     */
    public function WithoutEventName_Build_ThrowException()
    {
        $builder = new EventProxyStrategyRequestBuilderImpl();
        $builder->create()->build();
    }
}
