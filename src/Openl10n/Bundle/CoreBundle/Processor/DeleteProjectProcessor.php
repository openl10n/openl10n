<?php

namespace Openl10n\Bundle\CoreBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Action\DeleteProjectAction;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteProjectProcessor
{
    protected $projectManager;

    public function __construct(
        ObjectManager $projectManager,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->projectManager = $projectManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(DeleteProjectAction $action)
    {
        $project = $action->getProject();

        $this->projectManager->remove($project);
        $this->projectManager->flush($project);
    }
}
