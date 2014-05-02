<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Requestors;

use OpenClassrooms\CleanArchitecture\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

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
    public function createOnExceptionRequest($annotation, UseCaseRequest $useCaseRequest);
}
