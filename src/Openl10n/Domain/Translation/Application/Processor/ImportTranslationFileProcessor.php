<?php

namespace Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Translation\Application\Action\ImportTranslationFileAction;
use Openl10n\Domain\Translation\Repository\DomainRepository;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Openl10n\Domain\Translation\Service\Loader\TranslationLoaderInterface;
use Openl10n\Domain\Translation\Service\Uploader\FileUploaderInterface;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Slug;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ImportTranslationFileProcessor
{
    protected $domainRepository;
    protected $translationRepository;
    protected $fileUploader;
    protected $translationLoader;
    protected $eventDispatcher;

    public function __construct(
        DomainRepository $domainRepository,
        TranslationRepository $translationRepository,
        FileUploaderInterface $fileUploader,
        TranslationLoaderInterface $translationLoader,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->domainRepository = $domainRepository;
        $this->translationRepository = $translationRepository;
        $this->fileUploader = $fileUploader;
        $this->translationLoader = $translationLoader;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(ImportTranslationFileAction $action)
    {
        $project = $action->getProject();
        $locale = Locale::parse($action->getLocale());
        $domainSlug = new Slug($action->getDomain());

        // First upload translation file and extract message from it.
        $file = $this->fileUploader->upload($action->getFile());
        $catalogue = $this->translationLoader->loadMessages($file, $locale, (string) $domainSlug);
        $messages = $catalogue->all($domainSlug->toString());

        // Ensure domain exists
        $domain = $this->domainRepository->findOneBySlug($project, $domainSlug);
        if (null === $domain) {
            $domain = $this->domainRepository->createNew($project, $domainSlug);
            $this->domainRepository->save($domain);
        }

        // Start importing messages
        foreach ($messages as $key => $phrase) {
            $translationKey =
                $this->translationRepository->findOneByKey($domain, $key) ?:
                $this->translationRepository->createNewKey($domain, $key)
            ;

            $translationPhrase = $this->translationRepository->createNewPhrase($translationKey, $locale);

            if (!$translationKey->hasPhrase($locale)) {
                $translationPhrase->setText($phrase);
                $translationKey->addPhrase($translationPhrase);
            } elseif ($action->hasOptionErase()) {
                $translationPhrase->setText($phrase);
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
            $translationKeys = $this->translationRepository->findByDomain($domain);
            foreach ($translationKeys as $translationKey) {
                $identifier = $translationKey->getIdentifier();

                if (!isset($messages[$identifier])) {
                    $this->translationManager->remove($translationKey);
                }
            }
        }

        // Finally remove temporary file.
        $this->fileUploader->remove($file);

        return $domain;
    }
}
