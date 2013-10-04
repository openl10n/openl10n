<?php

namespace Openl10n\Bundle\CoreBundle\Factory;

use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Object\Locale;

interface LanguageFactoryInterface
{
    public function createNew(ProjectInterface $project, Locale $locale);
}
