<?php

namespace Openl10n\Domain\Project\Repository;

use Openl10n\Domain\Project\Model\Project;
use Openl10n\Value\String\Slug;

interface ProjectRepository
{
    /**
     * Create new project.
     *
     * @param Slug $slug Project's slug
     *
     * @return Project A new project instance
     */
    public function createNew(Slug $slug);

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
     * @return Project The project entity
     */
    public function findOneBySlug(Slug $slug);

    /**
     * Save a project.
     *
     * @param Project $project The project to save
     */
    public function save(Project $project);

    /**
     * Remove a project.
     *
     * @param Project $project The project to remove
     */
    public function remove(Project $project);
}
