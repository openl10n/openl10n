<?php

namespace Openl10n\Domain\Resource\Application\Processor;

use Openl10n\Bundle\InfraBundle\Specification\ResourceLocaleSpecification;
use Openl10n\Domain\Resource\Application\Action\ImportTranslationFileAction;
use Openl10n\Domain\Resource\Repository\ResourceRepository;
use Openl10n\Domain\Resource\Service\Loader\TranslationLoaderInterface;
use Openl10n\Domain\Resource\Service\Uploader\FileUploaderInterface;
use Openl10n\Domain\Translation\Application\Action\CreateTranslationKeyAction;
use Openl10n\Domain\Translation\Application\Action\DeleteTranslationKeyAction;
use Openl10n\Domain\Translation\Application\Action\EditTranslationPhraseAction;
use Openl10n\Domain\Translation\Application\Processor\CreateTranslationKeyProcessor;
use Openl10n\Domain\Translation\Application\Processor\DeleteTranslationKeyProcessor;
use Openl10n\Domain\Translation\Application\Processor\EditTranslationPhraseProcessor;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Openl10n\Domain\Translation\Value\Hash;
use Openl10n\Value\Localization\Locale;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ImportTranslationFileProcessor
{
    protected $resourceRepository;
    protected $translationRepository;
    protected $fileUploader;
    protected $translationLoader;
    protected $createTranslationKeyProcessor;
    protected $editTranslationPhraseProcessor;
    protected $deleteTranslationKeyProcessor;
    protected $eventDispatcher;

    public function __construct(
        ResourceRepository $resourceRepository,
        TranslationRepository $translationRepository,
        FileUploaderInterface $fileUploader,
        TranslationLoaderInterface $translationLoader,
        CreateTranslationKeyProcessor $createTranslationKeyProcessor,
        EditTranslationPhraseProcessor $editTranslationPhraseProcessor,
        DeleteTranslationKeyProcessor $deleteTranslationKeyProcessor,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->resourceRepository = $resourceRepository;
        $this->translationRepository = $translationRepository;
        $this->fileUploader = $fileUploader;
        $this->translationLoader = $translationLoader;
        $this->createTranslationKeyProcessor = $createTranslationKeyProcessor;
        $this->editTranslationPhraseProcessor = $editTranslationPhraseProcessor;
        $this->deleteTranslationKeyProcessor = $deleteTranslationKeyProcessor;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(ImportTranslationFileAction $action)
    {
        $resource = $action->getResource();
        $locale = Locale::parse($action->getLocale());

        //
        // First upload translation file and extract message from it.
        //
        $file = $this->fileUploader->upload($action->getFile());
        $catalogue = $this->translationLoader->loadMessages($file, $locale, 'messages');
        $messages = $catalogue->all('messages');

        // Index messages by hashing their keys.
        // This solves a problem when keys are too long, eg. when keys are
        // the phrase in the default language.
        $messageKeys = array_keys($messages);
        $messageHash = array_map(function($key) {
            return (string) new Hash($key);
        }, $messageKeys);
        $messagesIndex = array_combine($messageHash, $messageKeys);

        //
        // Extract all translations of the specific resource by hydrating the given locale
        //
        $specifications = new ResourceLocaleSpecification($resource, $locale);
        $translationPager = $this->translationRepository->findSatisfying($specifications);
        $translationPager->setMaxPerPage(99999);

        //
        // Iterate over existing translations
        //
        foreach ($translationPager as $translationKey) {
            $keyIdentifier = (string) $translationKey->getHash();

            if (!isset($messagesIndex[$keyIdentifier])) {
                // If current translation is not part of the file then clean it
                // if option was specified.
                // Note: the erase option should only be done with the project's default locale,
                // otherwise you may delete all translations which have not been translated yet.
                if ($action->hasOptionClean()) {
                    $deleteKeyAction = new DeleteTranslationKeyAction($translationKey);
                    $this->deleteTranslationKeyProcessor->execute($deleteKeyAction);
                }

                continue;
            }

            // Get phrase and mark translation as treated
            $newPhrase = $messages[$messagesIndex[$keyIdentifier]];
            unset($messages[$messagesIndex[$keyIdentifier]]);

            // Compare it to current phrase
            $phrase = $translationKey->getPhrase($locale);

            if (null === $phrase || ($newPhrase !== (string) $phrase->getText() && $action->hasOptionErase())) {
                // If phrase doesn't exist yet or is different, then edit it.
                $editPhraseAction = new EditTranslationPhraseAction($translationKey, $locale);
                $editPhraseAction->setText($newPhrase);
                $editPhraseAction->setApproved($action->hasOptionReviewed());
                $this->editTranslationPhraseProcessor->execute($editPhraseAction);
            } elseif ($action->hasOptionReviewed() && !$phrase->isApproved()) {
                // If reviewed option is set, then automatically mark translation
                // phrase as approved, without updating its text.
                $editPhraseAction = new EditTranslationPhraseAction($translationKey, $locale);
                $editPhraseAction->setApproved(true);
                $this->editTranslationPhraseProcessor->execute($editPhraseAction);
            }
        }

        //
        // Save the other phrases (ie. new translations)
        //
        foreach ($messages as $key => $phrase) {
            // Create the translation key
            $createKeyAction = new CreateTranslationKeyAction();
            $createKeyAction->setResource($resource);
            $createKeyAction->setIdentifier($key);
            $key = $this->createTranslationKeyProcessor->execute($createKeyAction);

            // Edit the text of the translation for given locale
            $editPhraseAction = new EditTranslationPhraseAction($key, $locale);
            $editPhraseAction->setText($phrase);
            $editPhraseAction->setApproved($action->hasOptionReviewed());
            $this->editTranslationPhraseProcessor->execute($editPhraseAction);
        }

        // Finally remove temporary file.
        $this->fileUploader->remove($file);

        return $resource;
    }
}
