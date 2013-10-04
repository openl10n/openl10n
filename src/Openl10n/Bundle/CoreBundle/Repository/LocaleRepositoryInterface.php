<?php

namespace Openl10n\Bundle\CoreBundle\Repository;

/**
 * Locale repository definition.
 */
interface LocaleRepositoryInterface
{
    /**
     * Get all known locales.
     *
     * @return array List of Locale objects
     */
    public function getLocales();
}
