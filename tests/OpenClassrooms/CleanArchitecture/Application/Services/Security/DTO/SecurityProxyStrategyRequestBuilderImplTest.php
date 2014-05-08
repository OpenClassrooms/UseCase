<?php

namespace OpenClassrooms\Tests\CleanArchitecture\Application\Services\Security\DTO;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Security\DTO\SecurityProxyStrategyRequestBuilderImpl;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class SecurityProxyStrategyRequestBuilderImplTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Security\Exceptions\AttributesMustBeDefinedException
     */
    public function WithoutAttributes_Build_ThrowException()
    {
        $builder = new SecurityProxyStrategyRequestBuilderImpl();
        $builder
            ->create()
            ->build();
    }
}
