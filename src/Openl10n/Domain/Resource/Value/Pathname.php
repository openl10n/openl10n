<?php

namespace Openl10n\Domain\Resource\Value;

class Pathname
{
    protected $value;

    public function __construct($value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Pathname can not be empty');
        }

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
