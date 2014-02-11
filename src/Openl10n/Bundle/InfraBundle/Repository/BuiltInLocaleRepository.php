<?php

namespace Openl10n\Bundle\InfraBundle\Repository;

/**
 * Locale repository default implementation using bundle configuration.
 */
class BuiltInLocaleRepository extends InMemoryLocaleRepository
{
    /**
     * Constructor.
     *
     * Nothing in parameter, it includes the bundled locales definition.
     */
    public function __construct()
    {
        $locales = include __DIR__.'/../Resources/data/locales.php';

        parent::__construct($locales);
    }
}
