<?php

namespace Openl10n\Domain\Translation\Value;

class Pathname
{
    protected $value;

    public function __construct($value)
    {
        $this->value = ltrim($value, '/');
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->value;
    }
}
