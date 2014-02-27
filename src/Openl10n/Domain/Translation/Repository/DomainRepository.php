<?php

namespace Openl10n\Domain\Translation\Repository;

use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Model\Domain;
use Openl10n\Value\String\Slug;

interface DomainRepository
{
    public function createNew(Project $project, Slug $slug);

    public function findByProject(Project $project);

    public function findOneBySlug(Project $project, Slug $slug);

    public function save(Domain $domain);

    public function remove(Domain $domain);
}
