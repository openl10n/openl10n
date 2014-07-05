<?php

namespace Openl10n\Value\String;

/**
 * Description value object.
 */
class Description
{
    protected $value;

    public function __construct($value = '')
    {
        if (null === $value) {
            $value = '';
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
