<?php

namespace Openl10n\Bundle\InfraBundle\Listener;

use Openl10n\Domain\Project\Application\Event\CreateProjectEvent;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Project\Application\Event\EditProjectEvent;
use Openl10n\Domain\Project\Repository\ProjectRepository;
use Openl10n\Domain\Project\Repository\LanguageRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LanguageListener implements EventSubscriberInterface
{
    protected $projectRepository;
    protected $languageRepository;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            CreateProjectEvent::NAME => array('ensureProjectDefaultLocaleOnCreation'),
            EditProjectEvent::NAME => array('ensureProjectDefaultLocaleOnEdit'),
        );
    }

    public function __construct(
        ProjectRepository $projectRepository,
        LanguageRepository $languageRepository
    )
    {
        $this->projectRepository = $projectRepository;
        $this->languageRepository = $languageRepository;
    }

    public function ensureProjectDefaultLocaleOnCreation(CreateProjectEvent $event)
    {
        $project = $event->getProject();
        $this->ensureProjectDefaultLocale($project);
    }

    public function ensureProjectDefaultLocaleOnEdit(EditProjectEvent $event)
    {
        $project = $event->getProject();
        $this->ensureProjectDefaultLocale($project);
    }

    private function ensureProjectDefaultLocale(Project $project)
    {
        $defaultLocale = $project->getDefaultLocale();

        $locale = $this->languageRepository->findOneByProject($project, $defaultLocale);

        if (null === $locale) {
            $language = $this->languageRepository->createNew($project, $defaultLocale);
            $this->languageRepository->save($language);
        }
    }
}
