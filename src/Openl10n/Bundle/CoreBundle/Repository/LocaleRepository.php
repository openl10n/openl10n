<?php

namespace Openl10n\Bundle\CoreBundle\Repository;

use Openl10n\Bundle\CoreBundle\Object\Locale;

/**
 * Locale repository default implementation.
 */
class LocaleRepository implements LocaleRepositoryInterface
{
    /**
     * @var array
     */
    protected $locales;

    /**
     * Construct with a list of locales.
     *
     * @param array $locales List of Locale objects
     */
    public function __construct(array $locales = array())
    {
        $this->locales = array_map(function($locale) {
            if ($locale instanceof Locale) {
                return $locale;
            }

            return new Locale($locale);
        }, $locales);
    }

    /**
     * {@inheritdoc}
     */
    public function getLocales()
    {
        return $this->locales;
    }
}
