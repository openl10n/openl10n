<?php

namespace Openl10n\Bundle\InfraBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Openl10n\Bundle\InfraBundle\Entity\Resource as ResourceEntity;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Resource\Model\Resource;
use Openl10n\Domain\Resource\Repository\ResourceRepository as ResourceRepositoryInterface;
use Openl10n\Domain\Resource\Value\Pathname;
use Openl10n\Domain\Translation\Model\Domain;
use Openl10n\Value\String\Slug;
use Rhumsaa\Uuid\Uuid;

class ResourceRepository extends EntityRepository implements ResourceRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew(Project $project, Pathname $pathname)
    {
        return new ResourceEntity($project, $pathname);
    }

    /**
     * {@inheritdoc}
     */
    public function findByProject(Project $project)
    {
        return $this->findBy(['project' => $project]);
    }

    /**
     * {@inheritdoc}
     */
    public function findOneById(Project $project, $id)
    {
        return $this->findOneBy(['project' => $project, 'id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Resource $resource)
    {
        $this->_em->persist($resource);
        $this->_em->flush($resource);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Resource $resource)
    {
        $this->_em->remove($resource);
        $this->_em->flush($resource);
    }
}
