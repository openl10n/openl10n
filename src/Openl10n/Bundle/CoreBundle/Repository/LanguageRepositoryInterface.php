<?php

namespace Openl10n\Bundle\CoreBundle\Repository;

use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Model\LanguageInterface;

/**
 * Project Locale repository definition.
 */
interface LanguageRepositoryInterface
{
    public function findByProject(ProjectInterface $project);
    public function findOneByProject(ProjectInterface $project, Locale $locale);
}
