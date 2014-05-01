<?php

namespace OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Requestors;

use OpenClassrooms\CleanArchitecture\BusinessRules\UseCases\UseCaseProxyImpl;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\Responders\UseCaseResponseStub;
use OpenClassrooms\Tests\CleanArchitecture\BusinessRules\UseCases\UseCaseStub;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class UseCaseProxyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function UseCase_Execute_ReturnResponse()
    {
        $proxy = new UseCaseProxyImpl();
        $proxy->setUseCase(new UseCaseStub());
        $response = $proxy->execute(new UseCaseRequestStub());

        $this->assertEquals(new UseCaseResponseStub(), $response);
    }
}
