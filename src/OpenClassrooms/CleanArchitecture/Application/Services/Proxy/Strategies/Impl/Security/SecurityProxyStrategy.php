<?php

namespace OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\Security;

use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Impl\DTO\ProxyStrategyResponseDTO;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\PreExecuteProxyStrategy;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\ProxyStrategyRequest;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Requestors\Security\SecurityProxyStrategyRequest;
use
    OpenClassrooms\CleanArchitecture\Application\Services\Proxy\Strategies\Responders\ProxyStrategyResponse;
use OpenClassrooms\CleanArchitecture\Application\Services\Security\Security;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class SecurityProxyStrategy implements PreExecuteProxyStrategy
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @return ProxyStrategyResponse
     */
    public function preExecute(ProxyStrategyRequest $proxyStrategyRequest)
    {
        /** @var SecurityProxyStrategyRequest $proxyStrategyRequest */
        $this->security->checkAccess(
            $proxyStrategyRequest->getAttributes(),
            $proxyStrategyRequest->getObject()
        );

        return new ProxyStrategyResponseDTO();
    }

    public function setSecurity(Security $security)
    {
        $this->security = $security;
    }
}
