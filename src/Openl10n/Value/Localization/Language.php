<?php

namespace Openl10n\Value\Localization;

/**
 * Representation of a language as a value object.
 */
final class Language
{
    /**
     * @var string
     */
    protected $languageCode;

    /**
     * Build a language object with a valid string.
     *
     * @param string $languageCode The language code
     */
    public function __construct($languageCode)
    {
        if (empty($languageCode)) {
            throw new \InvalidArgumentException('Language code string can not be empty');
        }

        $this->languageCode = $languageCode;
    }

    /**
     * String representation of the language.
     *
     * @return string This language as string
     */
    public function toString()
    {
        return $this->languageCode;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->toString();
    }
}
