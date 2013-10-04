<?php

namespace Openl10n\Bundle\CoreBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Action\CreateProjectAction;
use Openl10n\Bundle\CoreBundle\EventDispatcher\Event\ProjectEvent;
use Openl10n\Bundle\CoreBundle\EventDispatcher\ProjectEvents;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\CoreBundle\Factory\ProjectFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateProjectProcessor
{
    protected $projectFactory;
    protected $projectManager;
    protected $eventDispatcher;

    public function __construct(
        ProjectFactoryInterface $projectFactory,
        ObjectManager $projectManager,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->projectFactory = $projectFactory;
        $this->projectManager = $projectManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(CreateProjectAction $action)
    {
        $project = $this->projectFactory->createNew(new Slug($action->slug));

        $project->setName(new Name($action->name));
        $project->setDefaultLocale(new Locale($action->defaultLocale));

        $this->projectManager->persist($project);
        $this->projectManager->flush($project);

        $this->eventDispatcher->dispatch(
            ProjectEvents::CREATE,
            new ProjectEvent($project)
        );

        return $project;
    }
}
