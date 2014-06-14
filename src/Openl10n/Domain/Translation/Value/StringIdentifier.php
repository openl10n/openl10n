<?php

namespace Openl10n\Domain\Translation\Value;

class StringIdentifier
{
    protected $value;

    public function __construct($value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('String identifier can not be empty');
        }

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->value;
    }
}
