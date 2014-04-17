<?php

namespace Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Translation\Application\Action\UpdateResourceAction;
use Openl10n\Domain\Translation\Repository\ResourceRepository;
use Openl10n\Domain\Translation\Value\Pathname;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UpdateResourceProcessor
{
    protected $projectRepository;

    public function __construct(
        ResourceRepository $resourceRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->resourceRepository = $resourceRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(UpdateResourceAction $action)
    {
        $resource = $action->getResource();
        $pathname = new Pathname($action->getPathname());

        $resource->setPathname($pathname);

        $this->resourceRepository->save($resource);

        return $resource;
    }
}
