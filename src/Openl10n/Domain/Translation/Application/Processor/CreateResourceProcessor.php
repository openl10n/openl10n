<?php

namespace Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Translation\Application\Action\CreateResourceAction;
use Openl10n\Domain\Translation\Repository\ResourceRepository;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Openl10n\Domain\Translation\Service\Loader\TranslationLoaderInterface;
use Openl10n\Domain\Translation\Service\Uploader\FileUploaderInterface;
use Openl10n\Domain\Translation\Value\Pathname;
use Openl10n\Domain\Translation\Value\StringIdentifier;
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

        // First upload translation file and extract message from it.
        $file = $this->fileUploader->upload($action->getFile());
        $catalogue = $this->translationLoader->loadMessages($file, $locale, 'messages');
        $messages = $catalogue->all('messages');

        // Create resource file
        $resource = $this->resourceRepository->createNew($project, $pathname);
        $this->resourceRepository->save($resource);

        // Start importing messages
        foreach ($messages as $key => $phrase) {
            $identifier = new StringIdentifier($key);
            $translationKey = $this->translationRepository->createNewKey($resource, $identifier);

            $translationPhrase = $this->translationRepository->createNewPhrase($translationKey, $locale);
            $translationKey->addPhrase($translationPhrase);
            $translationPhrase->setText($phrase);

            // If reviewed option is set, then automatically mark
            // translation phrase as approved.
            if ($action->hasOptionReviewed()) {
                $translationPhrase->setApproved(true);
            }

            $this->translationRepository->saveKey($translationKey);
            $this->translationRepository->savePhrase($translationPhrase);
        }

        // Finally remove temporary file.
        $this->fileUploader->remove($file);

        return $resource;
    }
}
