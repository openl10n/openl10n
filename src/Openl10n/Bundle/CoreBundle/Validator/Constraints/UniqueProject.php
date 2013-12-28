<?php

namespace Openl10n\Bundle\CoreBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class UniqueProject extends Constraint
{
    public $message = 'This value is already used.';
    public $service = 'openl10n.validator.project_unique';

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
