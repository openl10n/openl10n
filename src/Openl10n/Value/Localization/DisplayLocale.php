<?php

namespace Openl10n\Value\Localization;

class DisplayLocale
{
    /**
     * @var Locale
     */
    protected $locale;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param Locale $locale
     * @param string $inLocale
     *
     * @return DisplayLocale
     */
    public static function createFromLocale(Locale $locale, $inLocale = null)
    {
        $name = $inLocale ?
            \Locale::getDisplayName((string) $locale, $inLocale) :
            \Locale::getDisplayName((string) $locale);

        return new self($locale, $name);
    }

    /**
     * @param string $value (eg. anglais (Royaume-Uni) (en_GB))
     *
     * @return DisplayLocale
     */
    public static function parse($value)
    {
        if (!preg_match('/^(.*) \((\w+)\)$/', $value, $matches)) {
            throw new \InvalidArgumentException(sprintf('Unable to parse display locale "%s"', $value));
        }

        $name = $matches[1];
        $locale = Locale::parse($matches[2]);

        return new self($locale, $name);
    }

    /**
     * @param Locale $locale
     * @param string $name
     */
    public function __construct(Locale $locale, $name)
    {
        $this->locale = $locale;
        $this->name = $name;
    }

    /**
     * @return Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s (%s)',
            $this->name,
            (string) $this->locale
        );
    }
}
