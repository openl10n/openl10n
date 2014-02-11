<?php

namespace Openl10n\Value\Localization;

/**
 * Representation of a locale as a value object.
 */
class Locale
{
    /**
     * @var Language
     */
    protected $language;

    /**
     * @var Region
     */
    protected $region;

    /**
     * @var array<Variant>
     */
    protected $variants;

    /**
     * Build locale object from a string.
     *
     * @param string $locale The locale as string
     *
     * @return Locale A Locale object
     */
    public static function parse($locale)
    {
        if (empty($locale)) {
            throw new \InvalidArgumentException('Locale string can not be empty');
        }

        $result = \Locale::parseLocale($locale);

        if (!is_array($result)) {
            throw new \RuntimeException(sprintf('Unable to parse locale "%s"', $locale));
        }

        $language = null;
        $region = null;
        $variants = array();
        foreach ($result as $key => $value) {
            if ('language' === $key) {
                $language = new Language($value);
            } elseif ('region' === $key) {
                $region = new Region($value);
            } elseif (0 === strpos($key, 'variant')) {
                $variants[] = new Variant($value);
            }
        }

        return new self($language, $region, $variants);
    }

    /**
     * Build a locale object with a valid string.
     *
     * @param string $locale The locale description
     */
    public function __construct(Language $language, Region $region = null, array $variants = array())
    {
        $this->language = $language;
        $this->region = $region;
        $this->variants = $variants;
    }

    /**
     * Gets the primary language for the locale.
     *
     * @return Language The primary language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Gets the region for the locale.
     *
     * @return Region The primary language
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Gets the variants for the locale.
     *
     * @return array List of variants
     */
    public function getVariants()
    {
        return $this->region;
    }

    /**
     * String representation of the locale.
     *
     * @return string This locale as string
     */
    public function toString()
    {
        $parts = array((string) $this->language);

        if ($this->region) {
            $parts[] = $this->region;
        }

        foreach ($this->variants as $variant) {
            $parts[] = $variant;
        }

        return implode('_', $parts);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->toString();
    }
}
