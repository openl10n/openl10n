<?php

namespace Openl10n\Value\Localization;

/**
 * Representation of a locale variant as a value object.
 */
final class Variant
{
    /**
     * @var string
     */
    protected $value;

    /**
     * Build a region object with a valid string.
     *
     * @param string $value The variant code
     */
    public function __construct($value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Variant string can not be empty');
        }

        $this->value = $value;
    }

    /**
     * String representation of the variant.
     *
     * @return string This variant as string
     */
    public function toString()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->toString();
    }
}
