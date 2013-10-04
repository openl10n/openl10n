<?php

namespace Openl10n\Bundle\CoreBundle\Doctrine\ORM\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Openl10n\Bundle\CoreBundle\Entity\Domain as DomainEntity;
use Openl10n\Bundle\CoreBundle\Model\DomainInterface;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\CoreBundle\Repository\DomainRepositoryInterface;

/**
 * Domain repository doctrine ORM implementation.
 */
class DomainRepository implements DomainRepositoryInterface
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;

    /**
     * @param ManagerRegistry $registry Doctrine registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function findByProject(ProjectInterface $project)
    {
        return $this->registry->getManager()
            ->getRepository('Openl10nCoreBundle:Domain')
            ->findBy(array('project' => $project), array('name' => 'asc'));
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBySlug(ProjectInterface $project, Slug $slug)
    {
        return $this->registry->getManager()
            ->getRepository('Openl10nCoreBundle:Domain')
            ->findOneBy(array('project' => $project, 'slug' => $slug));
    }
}
