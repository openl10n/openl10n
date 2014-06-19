<?php

namespace Openl10n\Domain\Resource\Application\Processor;

use Openl10n\Domain\Resource\Application\Action\ExportTranslationFileAction;
use Openl10n\Domain\Resource\Service\Dumper\TranslationDumperInterface;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Openl10n\Value\Localization\Locale;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Translation\MessageCatalogue;

class ExportTranslationFileProcessor
{
    protected $domainRepository;
    protected $translationRepository;
    protected $translationDumper;
    protected $eventDispatcher;

    public function __construct(
        TranslationRepository $translationRepository,
        TranslationDumperInterface $translationDumper,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->translationRepository = $translationRepository;
        $this->translationDumper = $translationDumper;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(ExportTranslationFileAction $action)
    {
        $resource = $action->getResource();
        $project = $resource->getProject();

        $locale = Locale::parse($action->getLocale());
        $format = $action->getFormat() ?: pathinfo($resource->getPathname(), PATHINFO_EXTENSION);

        // Dump translations has a messages array according to given options
        $translations = $this->translationRepository->findByResource($resource);
        $messages = array();

        foreach ($translations as $translation) {
            $key = $translation->getIdentifier();
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
        $catalogue = new MessageCatalogue($locale, array((string) 'messages' => $messages));

        // Dump to file
        $directory = sys_get_temp_dir().DIRECTORY_SEPARATOR.'export_'.mt_rand(0, 99999);
        $this->translationDumper->dumpMessages($catalogue, $directory, $format);
        $filename = 'messages'.'.'.$locale.'.'.$format;

        $filepath = $directory.DIRECTORY_SEPARATOR.$filename;

        return new File($filepath);
    }
}
