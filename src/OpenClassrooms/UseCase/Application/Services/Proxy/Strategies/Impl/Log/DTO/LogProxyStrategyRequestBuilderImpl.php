<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Log\DTO;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Log\LogProxyStrategyRequest;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Log\LogProxyStrategyRequestBuilder;
use OpenClassrooms\UseCase\BusinessRules\Requestors\UseCaseRequest;
use OpenClassrooms\UseCase\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class LogProxyStrategyRequestBuilderImpl implements LogProxyStrategyRequestBuilder
{

    /**
     * @var LogProxyStrategyRequestDTO
     */
    protected $logProxyStrategyRequest;

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function create()
    {
        $this->logProxyStrategyRequest = new LogProxyStrategyRequestDTO();

        return $this;
    }

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function withContext(array $context = array())
    {
        $this->logProxyStrategyRequest->context = $context;

        return $this;
    }

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function withLevel($level)
    {
        $this->logProxyStrategyRequest->level = $level;

        return $this;
    }

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function withMessage($message)
    {
        $this->logProxyStrategyRequest->message = $message;

        return $this;
    }

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function withUseCaseRequest(UseCaseRequest $useCaseRequest)
    {
        $this->logProxyStrategyRequest->useCaseRequest = $useCaseRequest;

        return $this;
    }

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function withUseCaseResponse(UseCaseResponse $useCaseResponse)
    {
        $this->logProxyStrategyRequest->useCaseResponse = $useCaseResponse;

        return $this;
    }

    /**
     * @return LogProxyStrategyRequestBuilder
     */
    public function withException(\Exception $exception)
    {
        $this->logProxyStrategyRequest->exception = $exception;

        return $this;
    }

    /**
     * @return LogProxyStrategyRequest
     */
    public function build()
    {
        return $this->logProxyStrategyRequest;
    }
}
