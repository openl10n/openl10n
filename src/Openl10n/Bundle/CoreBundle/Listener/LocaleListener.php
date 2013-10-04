<?php

namespace Openl10n\Bundle\CoreBundle\Listener;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\EventDispatcher\Event\ProjectEvent;
use Openl10n\Bundle\CoreBundle\EventDispatcher\ProjectEvents;
use Openl10n\Bundle\CoreBundle\Factory\LanguageFactoryInterface;
use Openl10n\Bundle\CoreBundle\Repository\LanguageRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LocaleListener implements EventSubscriberInterface
{
    protected $projectManager;
    protected $languageRepository;
    protected $languageFactory;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ProjectEvents::CREATE => array('ensureProjectDefaultLocale'),
            ProjectEvents::UPDATE => array('ensureProjectDefaultLocale'),
        );
    }

    public function __construct(
        ObjectManager $projectManager,
        LanguageRepositoryInterface $languageRepository,
        LanguageFactoryInterface $languageFactory
    )
    {
        $this->projectManager = $projectManager;
        $this->languageRepository = $languageRepository;
        $this->languageFactory = $languageFactory;
    }

    public function ensureProjectDefaultLocale(ProjectEvent $event)
    {
        $project = $event->getProject();
        $defaultLocale = $project->getDefaultLocale();

        $locale = $this->languageRepository->findOneByProject($project, $defaultLocale);

        if (null === $locale) {
            $language = $this->languageFactory->createNew($project, $defaultLocale);
            $this->projectManager->persist($language);
            $this->projectManager->flush($language);
        }
    }
}
