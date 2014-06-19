<?php

namespace Openl10n\Domain\Resource\Application\Processor;

use Openl10n\Domain\Resource\Application\Action\CreateResourceAction;
use Openl10n\Domain\Resource\Repository\ResourceRepository;
use Openl10n\Domain\Resource\Service\Loader\TranslationLoaderInterface;
use Openl10n\Domain\Resource\Service\Uploader\FileUploaderInterface;
use Openl10n\Domain\Resource\Value\Pathname;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateResourceProcessor
{
    protected $domainRepository;
    protected $translationRepository;
    protected $fileUploader;
    protected $translationLoader;
    protected $eventDispatcher;

    public function __construct(
        ResourceRepository $resourceRepository,
        TranslationRepository $translationRepository,
        FileUploaderInterface $fileUploader,
        TranslationLoaderInterface $translationLoader,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->resourceRepository = $resourceRepository;
        $this->translationRepository = $translationRepository;
        $this->fileUploader = $fileUploader;
        $this->translationLoader = $translationLoader;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(CreateResourceAction $action)
    {
        $project = $action->getProject();
        $locale = $project->getDefaultLocale();
        $pathname = new Pathname($action->getPathname());

        // Create resource file
        $resource = $this->resourceRepository->createNew($project, $pathname);
        $this->resourceRepository->save($resource);

        return $resource;
    }
}
