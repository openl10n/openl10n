<?php

namespace Openl10n\Bundle\CoreBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Action\ImportDomainAction;
use Openl10n\Bundle\CoreBundle\Factory\DomainFactoryInterface;
use Openl10n\Bundle\CoreBundle\Factory\TranslationFactoryInterface;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\CoreBundle\Repository\DomainRepositoryInterface;
use Openl10n\Bundle\CoreBundle\Repository\TranslationRepositoryInterface;
use Openl10n\Bundle\CoreBundle\Translation\TranslationLoaderInterface;
use Openl10n\Bundle\CoreBundle\Uploader\FileUploaderInterface;

class ImportDomainProcessor
{
    protected $domainRepository;
    protected $domainFactory;
    protected $translationRepository;
    protected $translationFactory;
    protected $fileUploader;
    protected $translationLoader;
    protected $domainManager;
    protected $translationManager;

    public function __construct(
        ObjectManager $domainManager,
        DomainRepositoryInterface $domainRepository,
        DomainFactoryInterface $domainFactory,
        ObjectManager $translationManager,
        TranslationRepositoryInterface $translationRepository,
        TranslationFactoryInterface $translationFactory,
        FileUploaderInterface $fileUploader,
        TranslationLoaderInterface $translationLoader
    )
    {
        $this->domainManager = $domainManager;
        $this->translationManager = $translationManager;
        $this->domainRepository = $domainRepository;
        $this->domainFactory = $domainFactory;
        $this->translationRepository = $translationRepository;
        $this->translationFactory = $translationFactory;
        $this->fileUploader = $fileUploader;
        $this->translationLoader = $translationLoader;
    }

    public function execute(ImportDomainAction $action)
    {
        $project = $action->getProject();
        $locale = new Locale($action->locale);
        $domainSlug = new Slug($action->slug);

        // First upload translation file and extract message from it.
        $file = $this->fileUploader->upload($action->file);
        $catalogue = $this->translationLoader->loadMessages($file, $locale, $domainSlug->toString());
        $messages = $catalogue->all($domainSlug->toString());

        // Ensure domain exists
        $domain = $this->domainRepository->findOneBySlug($project, $domainSlug);
        if (null === $domain) {
            $domain = $this->domainFactory->createNew($project, $domainSlug);
            $this->domainManager->persist($domain);
            $this->domainManager->flush($domain);
        }

        // Start importing messages
        foreach ($messages as $key => $phrase) {
            $translationKey =
                $this->translationRepository->findOneByKey($domain, $key) ?:
                $this->translationFactory->createNewKey($domain, $key)
            ;

            $translationPhrase = $translationKey->getPhrase($locale);

            if (null === $translationPhrase) {
                // If translation phrase is new, then we can safely create
                // a new one and set text to it.
                $translationPhrase = $this->translationFactory->createNewPhrase($translationKey, $locale);
                $translationPhrase->setText($phrase);
            } elseif ($action->hasOptionErase()) {
                // If translation phrase already exists, make sure erase
                // option is set before setting text.
                $translationPhrase->setText($phrase);
            }

            // If reviewed option is set, then automatically mark
            // translation phrase as approved.
            if ($action->hasOptionReviewed()) {
                $translationPhrase->setApproved(true);
            }

            $this->translationManager->persist($translationKey);
            $this->translationManager->persist($translationPhrase);
        }

        // If clean option is set, then remove every translations from this
        // domain which are not present in the file.
        if ($action->hasOptionClean()) {
            $translationKeys = $this->translationRepository->findByDomain($domain);
            foreach ($translationKeys as $translationKey) {
                $key = $translationKey->getKey();

                if (!isset($messages[$key])) {
                    $this->translationManager->remove($translationKey);
                }
            }
        }

        $this->translationManager->flush();

        // Finally remove temporary file.
        $this->fileUploader->remove($file);

        return $domain;
    }
}
