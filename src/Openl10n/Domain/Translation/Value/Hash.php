<?php

namespace Openl10n\Domain\Translation\Value;

class Hash
{
    protected $value;

    public function __construct($value)
    {
        $this->value = sha1((string) $value);
    }

    public function __toString()
    {
        return $this->value;
    }
}
