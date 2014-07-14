<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCase;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface ProxyStrategyRequestFactory
{
    /**
     * @return ProxyStrategyRequest
     */
    public function createPreExecuteRequest(
        $annotation,
        UseCase $useCase,
        UseCaseRequest $useCaseRequest
    );

    /**
     * @return ProxyStrategyRequest
     */
    public function createPostExecuteRequest(
        $annotation,
        UseCase $useCase,
        UseCaseRequest $useCaseRequest,
        UseCaseResponse $useCaseResponse
    );

    /**
     * @return ProxyStrategyRequest
     */
    public function createOnExceptionRequest(
        $annotation,
        UseCase $useCase,
        UseCaseRequest $useCaseRequest,
        \Exception $exception
    );
}
