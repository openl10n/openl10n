<?php

namespace Openl10n\Bundle\UserBundle\Doctrine\ORM\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Openl10n\Bundle\UserBundle\Repository\UserRepositoryInterface;
use Openl10n\Bundle\CoreBundle\Object\Slug;

/**
 * User repository doctrine ORM implementation.
 */
class UserRepository implements UserRepositoryInterface
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
            ->getRepository('Openl10nUserBundle:User')
            ->findBy(array(), array('username' => 'asc'));
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByUsername(Slug $username)
    {
        return $this->registry->getManager()
            ->getRepository('Openl10nUserBundle:User')
            ->findOneBy(array('username' => (string) $username));
    }
}
