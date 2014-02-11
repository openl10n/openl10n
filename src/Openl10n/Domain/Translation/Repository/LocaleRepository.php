<?php

namespace Openl10n\Domain\Translation\Repository;

/**
 * Locale repository definition.
 */
interface LocaleRepository
{
    /**
     * Get all known locales.
     *
     * @return array List of Locale objects
     */
    public function findAll();
}
