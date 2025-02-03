<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Proxy\Strategies\Requestors\Event\DTO;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Event\DTO\EventProxyStrategyRequestBuilderImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Event\Exceptions\EventNameMustBeDefinedException;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class EventProxyStrategyRequestBuilderImplTest extends TestCase
{
    /**
     * @test
     */
    public function WithoutEventName_Build_ThrowException()
    {
        $builder = new EventProxyStrategyRequestBuilderImpl();
        $this->expectException(EventNameMustBeDefinedException::class);

        $builder->create()->build();
    }
}
