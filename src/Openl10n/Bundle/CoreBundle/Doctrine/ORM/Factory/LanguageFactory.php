<?php

namespace Openl10n\Bundle\CoreBundle\Doctrine\ORM\Factory;

use Openl10n\Bundle\CoreBundle\Entity\Language;
use Openl10n\Bundle\CoreBundle\Factory\LanguageFactoryInterface;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Object\Locale;

class LanguageFactory implements LanguageFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew(ProjectInterface $project, Locale $locale)
    {
        return new Language($project, $locale);
    }
}
