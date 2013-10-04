<?php

namespace Openl10n\Bundle\CoreBundle\Repository;

use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;

/**
 * Project repository definition.
 */
interface ProjectRepositoryInterface
{
    /**
     * Get all projects models.
     *
     * @return array List of all projects
     */
    public function findAll();

    /**
     * Get a project entity by its slug.
     *
     * @param Slug $slug Slug identifying the project
     *
     * @return ProjectInterface The project entity
     */
    public function findOneBySlug(Slug $slug);
}
