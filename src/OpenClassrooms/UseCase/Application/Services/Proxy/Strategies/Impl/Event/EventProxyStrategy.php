<?php

namespace OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\Event;

use OpenClassrooms\UseCase\Application\Services\Event\Event;
use OpenClassrooms\UseCase\Application\Services\Event\EventFactory;
use
    OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Impl\DTO\ProxyStrategyResponseDTO;
use
    OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\Event\EventProxyStrategyRequest;
use
    OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\OnExceptionProxyStrategy;
use
    OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\PostExecuteProxyStrategy;
use
    OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\PreExecuteProxyStrategy;
use OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategy;
use
    OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use
    OpenClassrooms\UseCase\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class EventProxyStrategy implements PreExecuteProxyStrategy, PostExecuteProxyStrategy, OnExceptionProxyStrategy
{
    /**
     * @var Event
     */
    private $event;

    /**
     * @var EventFactory
     */
    private $eventFactory;

    /**
     * @return string
     */
    public function getType()
    {
        return ProxyStrategy::EVENT;
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function preExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        /** @var EventProxyStrategyRequest $proxyStrategyRequest */
        $event = $this->eventFactory->make(
            $proxyStrategyRequest->getEventName(),
            $proxyStrategyRequest->getUseCaseRequest()
        );

        $this->event->send($event);

        return new ProxyStrategyResponseDTO();
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function postExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        /** @var EventProxyStrategyRequest $proxyStrategyRequest */
        $event = $this->eventFactory->make(
            $proxyStrategyRequest->getEventName(),
            $proxyStrategyRequest->getUseCaseRequest(),
            $proxyStrategyRequest->getUseCaseResponse()
        );

        $this->event->send($event);

        return new ProxyStrategyResponseDTO();
    }

    /**
     * @return ProxyStrategyResponse
     */
    public function onException(ProxyStrategyRequest $proxyStrategyRequest)
    {
        /** @var EventProxyStrategyRequest $proxyStrategyRequest */
        $event = $this->eventFactory->make(
            $proxyStrategyRequest->getEventName(),
            $proxyStrategyRequest->getUseCaseRequest(),
            null,
            $proxyStrategyRequest->getException()
        );

        $this->event->send($event);

        return new ProxyStrategyResponseDTO();
    }

    public function setEvent(Event $event)
    {
        $this->event = $event;
    }

    public function setEventFactory(EventFactory $eventFactory)
    {
        $this->eventFactory = $eventFactory;
    }

}
