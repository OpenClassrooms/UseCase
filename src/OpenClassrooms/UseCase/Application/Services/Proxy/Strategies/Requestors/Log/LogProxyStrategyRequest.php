<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Log;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface LogProxyStrategyRequest extends ProxyStrategyRequest
{
    /**
     * @return array
     */
    public function getContext();

    /**
     * @return \Exception
     */
    public function getException();

    /**
     * @return string
     */
    public function getLevel();

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return UseCaseRequest
     */
    public function getUseCaseRequest();

    /**
     * @return UseCaseResponse
     */
    public function getUseCaseResponse();
}
