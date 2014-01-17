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
        $options = $action->options;

        $file = $this->fileUploader->upload($action->file);

        $catalogue = $this->translationLoader->loadMessages($file, $locale, $domainSlug->toString());

        $domain = $this->domainRepository->findOneBySlug($project, $domainSlug);
        if (null === $domain) {
            $domain = $this->domainFactory->createNew($project, $domainSlug);
            $this->domainManager->persist($domain);
            $this->domainManager->flush($domain);
        }

        $messages = $catalogue->all($domainSlug->toString());
        foreach ($messages as $key => $phrase) {
            $translationKey =
                $this->translationRepository->findOneByKey($domain, $key) ?:
                $this->translationFactory->createNewKey($domain, $key)
            ;

            $translationPhrase = $translationKey->getPhrase($locale);

            if (null === $translationPhrase) {
                $translationPhrase = $this->translationFactory->createNewPhrase($translationKey, $locale);
                $translationPhrase->setText($phrase);
            }

            $this->translationManager->persist($translationKey);
            $this->translationManager->persist($translationPhrase);
        }


        $this->translationManager->flush();

        $this->fileUploader->remove($file);

        return $domain;
    }
}
