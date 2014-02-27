<?php

namespace Openl10n\Domain\Project\Persistence\InMemory\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Project\Repository\ProjectRepository as ProjectRepositoryInterface;
use Openl10n\Value\String\Slug;

class ProjectRepository implements ProjectRepositoryInterface
{
    protected $projects;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function createNew(Slug $slug)
    {
        return new Project($slug);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->projects->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBySlug(Slug $slug)
    {
        foreach ($this->findAll() as $project) {
            if ((string) $project->getSlug() === (string) $slug) {
                return $project;
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Project $project)
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Project $project)
    {
        if (!$this->projects->contains($project)) {
            $this->projects->removeElement($project);
        }
    }
}
