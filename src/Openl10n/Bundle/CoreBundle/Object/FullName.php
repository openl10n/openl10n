<?php

namespace Openl10n\Bundle\CoreBundle\Object;

class FullName extends Name
{
    /**
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct($firstName, $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;

        parent::__construct($firstName.' '.$lastName);
    }
}
