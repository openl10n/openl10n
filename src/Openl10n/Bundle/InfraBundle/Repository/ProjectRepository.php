<?php

namespace Openl10n\Bundle\InfraBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Bundle\InfraBundle\Entity\Project as ProjectEntity;
use Openl10n\Domain\Project\Repository\ProjectRepository as ProjectRepositoryInterface;
use Openl10n\Value\String\Slug;

class ProjectRepository extends EntityRepository implements ProjectRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew(Slug $slug)
    {
        return new ProjectEntity($slug);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->findBy(array());
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBySlug(Slug $slug)
    {
        return $this->findOneBy(['slug' => (string) $slug]);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Project $project)
    {
        $this->_em->persist($project);
        $this->_em->flush($project);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Project $project)
    {
        $this->_em->remove($project);
        $this->_em->flush($project);
    }
}
