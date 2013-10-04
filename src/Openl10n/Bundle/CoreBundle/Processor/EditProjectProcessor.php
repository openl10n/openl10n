<?php

namespace Openl10n\Bundle\CoreBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Action\EditProjectAction;
use Openl10n\Bundle\CoreBundle\EventDispatcher\Event\ProjectEvent;
use Openl10n\Bundle\CoreBundle\EventDispatcher\ProjectEvents;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Repository\ProjectRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EditProjectProcessor
{
    protected $projectRepository;
    protected $projectManager;
    protected $eventDispatcher;

    public function __construct(
        ProjectRepositoryInterface $projectRepository,
        ObjectManager $projectManager,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->projectRepository = $projectRepository;
        $this->projectManager = $projectManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(EditProjectAction $action)
    {
        $project = $action->getProject();
        $project->setName(new Name($action->name));
        $project->setDefaultLocale(new Locale($action->defaultLocale));

        $this->projectManager->persist($project);
        $this->projectManager->flush($project);

        $this->eventDispatcher->dispatch(
            ProjectEvents::UPDATE,
            new ProjectEvent($project)
        );

        return $project;
    }
}
