<?php

namespace Openl10n\Domain\Project\Application\Processor;

use Openl10n\Domain\Project\Application\Action\EditProjectAction;
use Openl10n\Domain\Project\Application\Event\EditProjectEvent;
use Openl10n\Domain\Project\Repository\ProjectRepository;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EditProjectProcessor
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

    public function execute(EditProjectAction $action)
    {
        $name = new Name($action->getName());
        $locale = Locale::parse($action->getDefaultLocale());

        $project = $action->getProject();
        $oldProject = clone $project;

        $project->setName($name);
        $project->setDefaultLocale($locale);

        $this->projectRepository->save($project);

        $this->eventDispatcher->dispatch(
           EditProjectEvent::NAME,
           new EditProjectEvent($project, $oldProject)
        );

        return $project;
    }
}
