<?php

namespace Openl10n\Bundle\CoreBundle\Object;

/**
 * Representation of a locale as a value object.
 */
class Locale
{
    /**
     * @var string
     */
    protected $locale;

    protected $flagMapping = array(
        'ar' => 'ae',
        'be' => 'by',
        'bg' => 'bg',
        'ca' => 'es',
        'cs' => 'cz',
        'da' => 'dk',
        'de' => 'de',
        'el' => 'gr',
        'en' => 'gb',
        'es' => 'es',
        'et' => 'ee',
        'fi' => 'fi',
        'fr' => 'fr',
        'ga' => 'ie',
        'hi' => 'in',
        'hr' => 'hr',
        'hu' => 'hu',
        'in' => 'id',
        'is' => 'is',
        'it' => 'it',
        'iw' => 'il',
        'ja' => 'jp',
        'ko' => 'kr',
        'lt' => 'lt',
        'lv' => 'lv',
        'mk' => 'mk',
        'ms' => 'my',
        'mt' => 'mt',
        'nl' => 'nl',
        'no' => 'no',
        'pl' => 'pl',
        'pt' => 'pt',
        'ro' => 'ro',
        'ru' => 'ru',
        'sk' => 'sk',
        'sl' => 'si',
        'sq' => 'al',
        'sr' => 'rs',
        'sv' => 'se',
        'th' => 'th',
        'tr' => 'tr',
        'uk' => 'ua',
        'vi' => 'vn',
        'zh' => 'cn',
    );

    /**
     * Build a locale object with a valid string.
     *
     * @param string $locale The locale description
     */
    public function __construct($locale)
    {
        $this->locale = \Locale::canonicalize($locale);
    }

    /**
     * Gets the flag for the locale or 'unknown'
     *
     * @return string The flag code or 'unknown'
     */
    public function getFlag()
    {
        if ($this->getRegion() !== '') {
            return strtolower($this->getRegion());
        } else if (array_key_exists($this->getPrimaryLanguage(), $this->flagMapping)) {
            return $this->flagMapping[$this->getPrimaryLanguage()];
        } else {
            return 'unknown';
        }
    }

    /**
     * Gets the primary language for the locale.
     *
     * @return string The primary language
     */
    public function getPrimaryLanguage()
    {
        return \Locale::getPrimaryLanguage($this->locale);
    }

    /**
     * Gets the region for the locale.
     *
     * @return string The primary language
     */
    public function getRegion()
    {
        return \Locale::getRegion($this->locale);
    }

    /**
     * Returns an appropriately localized display name for the locale.
     *
     * @return string The display name
     */
    public function getDisplayName($inLocale = null)
    {
        return $inLocale ?
            \Locale::getDisplayName($this->locale, $inLocale) :
            \Locale::getDisplayName($this->locale)
        ;
    }

    /**
     * Returns an appropriately localized display language for the locale.
     *
     * @return string The display language
     */
    public function getDisplayLanguage($inLocale = null)
    {
        return $inLocale ?
            \Locale::getDisplayLanguage($this->locale, $inLocale) :
            \Locale::getDisplayLanguage($this->locale)
        ;
    }

    /**
     * Returns an appropriately localized display region for the locale.
     *
     * @return string The display region
     */
    public function getDisplayRegion($inLocale = null)
    {
        return $inLocale ?
            \Locale::getDisplayRegion($this->locale, $inLocale) :
            \Locale::getDisplayRegion($this->locale)
        ;
    }

    /**
     * Compare to another locale object.
     *
     * @param Locale $locale
     *
     * @return Boolean True if the two locales have the same representation
     */
    public function equals(Locale $locale)
    {
        return $this->toString() === $locale->toString();
    }

    /**
     * String representation of the locale.
     *
     * @return string This locale as string
     */
    public function toString()
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->toString();
    }
}
