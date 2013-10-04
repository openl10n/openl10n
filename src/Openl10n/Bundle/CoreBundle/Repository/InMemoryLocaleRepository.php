<?php

namespace Openl10n\Bundle\CoreBundle\Repository;

use Openl10n\Bundle\CoreBundle\Model\Locale;

/**
 * Locale repository default implementation using bundle configuration.
 */
class InMemoryLocaleRepository extends LocaleRepository
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
