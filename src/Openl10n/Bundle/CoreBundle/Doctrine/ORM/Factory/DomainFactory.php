<?php

namespace Openl10n\Bundle\CoreBundle\Doctrine\ORM\Factory;

use Openl10n\Bundle\CoreBundle\Entity\Domain;
use Openl10n\Bundle\CoreBundle\Factory\DomainFactoryInterface;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Object\Slug;

class DomainFactory implements DomainFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew(ProjectInterface $project, Slug $slug)
    {
        return new Domain($project, $slug);
    }
}
