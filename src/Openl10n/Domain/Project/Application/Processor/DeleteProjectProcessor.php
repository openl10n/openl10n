<?php

namespace Openl10n\Domain\Project\Application\Processor;

use Openl10n\Domain\Project\Application\Action\DeleteProjectAction;
use Openl10n\Domain\Project\Repository\ProjectRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteProjectProcessor
{
    protected $projectRepository;
    protected $eventDispatcher;

    public function __construct(
        ProjectRepository $projectRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->projectRepository = $projectRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(DeleteProjectAction $action)
    {
        $project = $action->getProject();

        $this->projectRepository->remove($project);

        return $project;
    }
}
