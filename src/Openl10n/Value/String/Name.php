<?php

namespace Openl10n\Value\String;

/**
 * Name value object.
 */
class Name
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function toString()
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->toString();
    }
}
