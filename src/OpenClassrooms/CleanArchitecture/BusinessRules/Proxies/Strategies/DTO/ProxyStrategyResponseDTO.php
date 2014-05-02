<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Strategies\DTO;

use OpenClassrooms\CleanArchitecture\BusinessRules\Proxies\Responders\ProxyStrategyResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
class ProxyStrategyResponseDTO implements ProxyStrategyResponse
{
    /**
     * @var string
     */
    public $data;

    /**
     * @var bool
     */
    public $stopExecution = false;

    public function __construct($data = null, $stopExecution = false)
    {
        $this->data = $data;
        $this->stopExecution = $stopExecution;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function stopExecution()
    {
        return $this->stopExecution;
    }

}
