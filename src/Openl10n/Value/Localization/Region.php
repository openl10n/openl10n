<?php

namespace Openl10n\Value\Localization;

/**
 * Representation of a region as a value object.
 */
final class Region
{
    /**
     * @var string
     */
    protected $regionCode;

    /**
     * Build a region object with a valid string.
     *
     * @param string $regionCode The region code
     */
    public function __construct($regionCode)
    {
        if (empty($regionCode)) {
            throw new \InvalidArgumentException('Region code string can not be empty');
        }

        $this->regionCode = $regionCode;
    }

    /**
     * String representation of the region.
     *
     * @return string This region as string
     */
    public function toString()
    {
        return $this->regionCode;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->toString();
    }
}
