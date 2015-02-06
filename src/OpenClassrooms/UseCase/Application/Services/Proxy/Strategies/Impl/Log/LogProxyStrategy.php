<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Log;

use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\DTO\ProxyStrategyResponseDTO;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Log\LogProxyStrategyRequest;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\OnExceptionProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\PostExecuteProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\PreExecuteProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;
use Psr\Log\LoggerInterface;

/**
 * @author Romain Kuzniak <romain.kuzniak@turn-it-up.org>
 */
class LogProxyStrategy implements PreExecuteProxyStrategy, PostExecuteProxyStrategy, OnExceptionProxyStrategy
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @return string
     */
    public function getType()
    {
        return ProxyStrategy::LOG;
    }

    /**
     * @param LogProxyStrategyRequest $proxyStrategyRequest
     *
     * @return ProxyStrategyResponse
     */
    public function preExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        $this->log($proxyStrategyRequest);

        return new ProxyStrategyResponseDTO();
    }

    private function log(LogProxyStrategyRequest $proxyStrategyRequest)
    {
        $this->logger->log(
            $proxyStrategyRequest->getLevel(),
            $proxyStrategyRequest->getMessage(),
            $proxyStrategyRequest->getContext()
        );
    }

    /**
     * @param LogProxyStrategyRequest $proxyStrategyRequest
     *
     * @return ProxyStrategyResponse
     */
    public function postExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        $this->log($proxyStrategyRequest);

        return new ProxyStrategyResponseDTO();
    }

    /**
     * @param LogProxyStrategyRequest $proxyStrategyRequest
     *
     * @return ProxyStrategyResponse
     */
    public function onException(ProxyStrategyRequest $proxyStrategyRequest)
    {
        $this->log($proxyStrategyRequest);

        return new ProxyStrategyResponseDTO();
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
