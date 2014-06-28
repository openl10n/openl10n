<?php

namespace Openl10n\Domain\Resource\Application\Processor;

use Openl10n\Domain\Resource\Application\Action\ImportTranslationFileAction;
use Openl10n\Domain\Resource\Service\Loader\TranslationLoaderInterface;
use Openl10n\Domain\Resource\Service\Uploader\FileUploaderInterface;
use Openl10n\Domain\Resource\Repository\ResourceRepository;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Openl10n\Domain\Translation\Value\StringIdentifier;
use Openl10n\Value\Localization\Locale;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ImportTranslationFileProcessor
{
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

    public function execute(ImportTranslationFileAction $action)
    {
        $resource = $action->getResource();
        $locale = Locale::parse($action->getLocale());

        // First upload translation file and extract message from it.
        $file = $this->fileUploader->upload($action->getFile());
        $catalogue = $this->translationLoader->loadMessages($file, $locale, 'messages');
        $messages = $catalogue->all('messages');

        // Start importing messages
        foreach ($messages as $key => $phrase) {
            $identifier = new StringIdentifier($key);
            $translationKey =
                $this->translationRepository->findOneByKey($resource, $identifier) ?:
                $this->translationRepository->createNewKey($resource, $identifier)
            ;

            $translationPhrase = $translationKey->getPhrase($locale);

            if (null === $translationPhrase) {
                // If phrase doesn't exist, then create a new one and
                // attach the given text.
                $translationPhrase = $this->translationRepository->createNewPhrase($translationKey, $locale);
                $translationKey->addPhrase($translationPhrase);

                $translationPhrase->setText($phrase ?: '');
            } elseif ($action->hasOptionErase()) {
                // If phrase already exist, then ecrase text only
                // if option is declared.
                $translationPhrase->setText($phrase ?: '');
            }

            // If reviewed option is set, then automatically mark
            // translation phrase as approved.
            if ($action->hasOptionReviewed()) {
                $translationPhrase->setApproved(true);
            }

            $this->translationRepository->saveKey($translationKey);
            $this->translationRepository->savePhrase($translationPhrase);
        }

        // If clean option is set, then remove every translations from this
        // domain which are not present in the file.
        if ($action->hasOptionClean()) {
            // $translationKeys = $this->translationRepository->findByDomain($domain);
            // foreach ($translationKeys as $translationKey) {
            //     $identifier = $translationKey->getIdentifier();

            //     if (!isset($messages[$identifier])) {
            //         $this->translationManager->remove($translationKey);
            //     }
            // }
        }

        // Finally remove temporary file.
        $this->fileUploader->remove($file);

        return $resource;
    }
}
