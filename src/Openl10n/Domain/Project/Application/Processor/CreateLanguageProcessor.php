<?php

namespace Openl10n\Domain\Project\Application\Processor;

use Openl10n\Domain\Project\Application\Action\CreateLanguageAction;
use Openl10n\Domain\Project\Repository\LanguageRepository;
use Openl10n\Value\Localization\Locale;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateLanguageProcessor
{
    protected $languageRepository;
    protected $eventDispatcher;

    public function __construct(
        LanguageRepository $languageRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->languageRepository = $languageRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(CreateLanguageAction $action)
    {
        $project = $action->getProject();
        $locale = Locale::parse($action->getLocale());

        $language = $this->languageRepository->createNew($project, $locale);

        $this->languageRepository->save($language);

        return $language;
    }
}
