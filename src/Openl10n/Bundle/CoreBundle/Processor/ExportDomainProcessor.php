<?php

namespace Openl10n\Bundle\CoreBundle\Processor;

use Openl10n\Bundle\CoreBundle\Action\ExportDomainAction;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\CoreBundle\Repository\DomainRepositoryInterface;
use Openl10n\Bundle\CoreBundle\Repository\TranslationRepositoryInterface;
use Openl10n\Bundle\CoreBundle\Translation\TranslationDumperInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Translation\MessageCatalogue;

class ExportDomainProcessor
{
    protected $domainRepository;
    protected $translationRepository;
    protected $translationDumper;

    public function __construct(
        DomainRepositoryInterface $domainRepository,
        TranslationRepositoryInterface $translationRepository,
        TranslationDumperInterface $translationDumper
    )
    {
        $this->domainRepository = $domainRepository;
        $this->translationRepository = $translationRepository;
        $this->translationDumper = $translationDumper;
    }

    public function execute(ExportDomainAction $action)
    {
        $project = $action->getProject();

        $locale = new Locale($action->locale);
        $domainSlug = new Slug($action->domain);
        $format = $action->format;

        // Fetch given domain.
        $domain = $this->domainRepository->findOneBySlug($project, $domainSlug);
        if (null === $domain) {
            throw new \InvalidArgumentException(sprintf('Domain %s not found', $domainSlug));
        }

        // Dump translations has a messages array according to given options
        $translations = $this->translationRepository->findByDomain($domain);
        $messages = array();

        foreach ($translations as $translation) {
            $key = $translation->getKey();
            $phrase = $translation->getPhrase($locale);

            // Ignore non approved phrase if reviewed option is set
            if (null !== $phrase && $action->hasOptionReviewed() && !$phrase->isApproved()) {
                $phrase = null;
            }

            // Fallback on default locale if option is set
            if (null === $phrase && $action->hasOptionFallbackLocale()) {
                $phrase = $translation->getPhrase($project->getDefaultLocale());
            }

            if (null !== $phrase) {
                // If phrase is valid, get text
                $text = $phrase->getText();
            } elseif ($action->hasOptionFallbackKey()) {
                // If phrase is not set, and has key fallback, then use key as text
                $text = $key;
            } else {
                // If phrase is not set, ignore it
                continue;
            }

            $messages[$key] = $text;
        }

        // Export messages into a MessageCatalogue
        $catalogue = new MessageCatalogue($locale, array((string) $domain->getSlug() => $messages));

        // Dump to file
        $directory = sys_get_temp_dir().DIRECTORY_SEPARATOR.'export_'.mt_rand(0, 99999);
        $this->translationDumper->dumpMessages($catalogue, $directory, $format);
        $filename = $domainSlug.'.'.$locale.'.'.$format;
        $filepath = $directory.DIRECTORY_SEPARATOR.$filename;

        return new File($filepath);
    }
}
