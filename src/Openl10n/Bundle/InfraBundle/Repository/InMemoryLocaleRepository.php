<?php

namespace Openl10n\Bundle\InfraBundle\Repository;

use Openl10n\Value\Localization\Locale;
use Openl10n\Domain\Translation\Repository\LocaleRepository;

/**
 * Locale repository default implementation.
 */
class InMemoryLocaleRepository implements LocaleRepository
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

            return Locale::parse($locale);
        }, $locales);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->locales;
    }
}
