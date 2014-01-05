<?php

namespace Openl10n\Bundle\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class UniqueEmail extends Constraint
{
    public $message = 'This value is already used.';
    public $service = 'openl10n.validator.user_email_unique';

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return $this->service;
    }

    /**
     * {@inheritDoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
