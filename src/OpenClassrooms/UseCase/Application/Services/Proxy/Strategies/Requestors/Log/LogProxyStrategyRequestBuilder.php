<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Log;

use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
interface LogProxyStrategyRequestBuilder
{
    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function create();

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function withContext(array $context = array());

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function withLevel($level);

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function withMessage($message);

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function withUseCaseRequest(UseCaseRequest $useCaseRequest);

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function withUseCaseResponse(UseCaseResponse $useCaseResponse);

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function withException(\Exception $exception);

    /**
     * @return LogProxyStrategyRequest
     */
    public function build();
}
