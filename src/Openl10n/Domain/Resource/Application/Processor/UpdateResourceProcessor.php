<?php

namespace Openl10n\Domain\Resource\Application\Processor;

use Openl10n\Domain\Resource\Value\Pathname;
use Openl10n\Domain\Resource\Application\Action\UpdateResourceAction;
use Openl10n\Domain\Resource\Repository\ResourceRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UpdateResourceProcessor
{
    protected $resourceRepository;
    protected $eventDispatcher;

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
