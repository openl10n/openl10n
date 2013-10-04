<?php

namespace Openl10n\Bundle\CoreBundle\Doctrine\ORM\Factory;

use Openl10n\Bundle\CoreBundle\Entity\Project;
use Openl10n\Bundle\CoreBundle\Factory\ProjectFactoryInterface;
use Openl10n\Bundle\CoreBundle\Object\Slug;

class ProjectFactory implements ProjectFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew(Slug $slug)
    {
        return new Project($slug);
    }
}
