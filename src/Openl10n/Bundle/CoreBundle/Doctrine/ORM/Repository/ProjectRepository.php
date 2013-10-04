<?php

namespace Openl10n\Bundle\CoreBundle\Doctrine\ORM\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Openl10n\Bundle\CoreBundle\Entity\Project as ProjectEntity;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\CoreBundle\Repository\ProjectRepositoryInterface;

/**
 * Project repository doctrine ORM implementation.
 */
class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

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
    public function findAll()
    {
        return $this->registry->getManager()
            ->getRepository('Openl10nCoreBundle:Project')
            ->findBy(array(), array('name' => 'asc'));
    }

    /**
     * {@inheritdoc}
     */
    public function findOneBySlug(Slug $slug)
    {
        return $this->registry->getManager()
            ->getRepository('Openl10nCoreBundle:Project')
            ->findOneBy(array('slug' => (string) $slug));
    }
}
