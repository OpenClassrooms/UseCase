<?php

namespace OpenClassrooms\CleanArchitecture\BusinessRules\Requestors;

use OpenClassrooms\CleanArchitecture\BusinessRules\Responders\UseCaseResponse;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 */
interface UseCase
{
    /**
     * @return UseCaseResponse
     */
    public function execute(UseCaseRequest $useCaseRequest);
}
