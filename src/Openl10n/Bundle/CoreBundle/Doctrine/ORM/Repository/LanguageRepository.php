<?php

namespace Openl10n\Bundle\CoreBundle\Doctrine\ORM\Repository;

use Doctrine\Common\Persistence\ManagerRegistry;
use Openl10n\Bundle\CoreBundle\Entity\Language as LanguageEntity;
use Openl10n\Bundle\CoreBundle\Model\LanguageInterface;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Repository\LanguageRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Project Locale repository doctrine ORM implementation.
 */
class LanguageRepository implements LanguageRepositoryInterface
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
     * @param ManagerRegistry          $registry        Doctrine registry
     * @param EventDispatcherInterface $eventDispatcher Event Dispatcher
     */
    public function __construct(ManagerRegistry $registry, EventDispatcherInterface $eventDispatcher)
    {
        $this->registry = $registry;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function findByProject(ProjectInterface $project)
    {
        return $this->registry->getManager()
            ->getRepository('Openl10nCoreBundle:Language')
            ->findBy(array('project' => $project));
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByProject(ProjectInterface $project, Locale $locale)
    {
        return $this->registry->getManager()
            ->getRepository('Openl10nCoreBundle:Language')
            ->findOneBy(array('project' => $project, 'locale' => $locale));
    }
}
