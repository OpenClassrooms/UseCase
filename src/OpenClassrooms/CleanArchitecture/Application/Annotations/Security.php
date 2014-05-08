<?php

namespace OpenClassrooms\CleanArchitecture\Application\Annotations;

/**
 * @author Romain Kuzniak <romain.kuzniak@openclassrooms.com>
 * @Annotation
 */
class Security
{
    /**
     * @var mixed
     */
    public $roles;

    /**
     * @var bool
     */
    public $checkRequest = false;

    /**
     * @var string
     */
    public $checkField;

    public function __construct(array $values)
    {
        if (!isset($values['roles'])) {
            throw new \InvalidArgumentException ('Roles MUST be defined');
        }
        $this->roles = is_array($values['roles']) ? $values['roles'] :
            array_map('trim', explode(',', $values['roles']));
        if (isset($values['checkRequest'])) {
            $this->checkRequest = $values['checkRequest'];
        }

        if (isset($values['checkField'])) {
            $this->checkField = $values['checkField'];
        }
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return boolean
     */
    public function checkRequest()
    {
        return $this->checkRequest;
    }

    /**
     * @return string
     */
    public function getCheckField()
    {
        return $this->checkField;
    }

}
