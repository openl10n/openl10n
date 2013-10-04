<?php

namespace Openl10n\Bundle\CoreBundle\Factory;

use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Object\Slug;

interface DomainFactoryInterface
{
    public function createNew(ProjectInterface $project, Slug $slug);
}
