<?php

namespace OpenClassrooms\Tests\UseCase\Application\Services\Security\DTO;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Security\DTO\SecurityProxyStrategyRequestBuilderImpl;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Security\Exceptions\AttributesMustBeDefinedException;
use PHPUnit\Framework\TestCase;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class SecurityProxyStrategyRequestBuilderImplTest extends TestCase
{
    /**
     * @test
     */
    public function WithoutAttributes_Build_ThrowException()
    {
        $this->expectException(AttributesMustBeDefinedException::class);

        $builder = new SecurityProxyStrategyRequestBuilderImpl();
        $builder
            ->create()
            ->build();
    }
}
