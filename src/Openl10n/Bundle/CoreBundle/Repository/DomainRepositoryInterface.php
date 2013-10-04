<?php

namespace Openl10n\Bundle\CoreBundle\Repository;

use Openl10n\Bundle\CoreBundle\Model\DomainInterface;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;

interface DomainRepositoryInterface
{
    public function findByProject(ProjectInterface $project);
    public function findOneBySlug(ProjectInterface $project, Slug $slug);
}
