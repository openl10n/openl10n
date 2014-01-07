<?php

namespace Openl10n\Bundle\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class UniqueUser extends Constraint
{
    public $message = 'This value is already used.';
    public $service = 'openl10n.validator.user_unique';

    /**
     * The validator must be defined as a service with this name.
     *
     * @return string
     */
    public function validatedBy()
    {
        return $this->service;
    }
}
