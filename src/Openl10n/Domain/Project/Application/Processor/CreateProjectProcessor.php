<?php

namespace Openl10n\Domain\Project\Application\Processor;

use Openl10n\Domain\Project\Application\Action\CreateProjectAction;
use Openl10n\Domain\Project\Application\Event\CreateProjectEvent;
use Openl10n\Domain\Project\Repository\ProjectRepository;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;
use Openl10n\Value\String\Slug;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateProjectProcessor
{
    protected $projectRepository;

    public function __construct(
        ProjectRepository $projectRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->projectRepository = $projectRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(CreateProjectAction $action)
    {
        $name = new Name($action->getName());
        $slug = new Slug($action->getSlug());
        $locale = Locale::parse($action->getDefaultLocale());

        $project = $this->projectRepository->createNew($slug);
        $project->setName($name);
        $project->setDefaultLocale($locale);

        $this->projectRepository->save($project);

        $this->eventDispatcher->dispatch(
           CreateProjectEvent::NAME,
           new CreateProjectEvent($project)
        );

        return $project;
    }
}
