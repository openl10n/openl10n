<?php

namespace Openl10n\Bundle\InfraBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Translation\Model\Domain;
use Openl10n\Bundle\InfraBundle\Entity\Domain as DomainEntity;
use Openl10n\Domain\Translation\Repository\DomainRepository as DomainRepositoryInterface;
use Openl10n\Value\String\Slug;

class DomainRepository extends EntityRepository implements DomainRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createNew(Project $project, Slug $slug)
    {
        return new DomainEntity($project, $slug);
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
    public function findOneBySlug(Project $project, Slug $slug)
    {
        return $this->findOneBy(['project' => $project, 'slug' => (string) $slug]);
    }

    /**
     * {@inheritdoc}
     */
    public function save(Domain $domain)
    {
        $this->_em->persist($domain);
        $this->_em->flush($domain);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Domain $domain)
    {
        $this->_em->remove($domain);
        $this->_em->flush($domain);
    }
}
