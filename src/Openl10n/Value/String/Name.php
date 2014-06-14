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
        if (empty($value)) {
            throw new \InvalidArgumentException('Name value can not be empty');
        }

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
