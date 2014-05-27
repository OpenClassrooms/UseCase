<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface ProxyStrategyRequestFactory
{
    /**
     * @return ProxyStrategyRequest
     */
    public function createPreExecuteRequest($annotation, UseCaseRequest $useCaseRequest);

    /**
     * @return ProxyStrategyRequest
     */
    public function createPostExecuteRequest(
        $annotation,
        UseCaseRequest $useCaseRequest,
        UseCaseResponse $useCaseResponse
    );

    /**
     * @return ProxyStrategyRequest
     */
    public function createOnExceptionRequest(
        $annotation,
        UseCaseRequest $useCaseRequest,
        \Exception $exception
    );
}
