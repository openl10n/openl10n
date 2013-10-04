<?php

namespace Openl10n\Bundle\CoreBundle\Object;

/**
 * Name value object.
 */
class Name
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function toString()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->toString();
    }
}
