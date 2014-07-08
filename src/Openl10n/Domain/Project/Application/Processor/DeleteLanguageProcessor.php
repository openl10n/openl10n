<?php

namespace Openl10n\Domain\Project\Application\Processor;

use Openl10n\Domain\Project\Application\Action\DeleteLanguageAction;
use Openl10n\Domain\Project\Repository\LanguageRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteLanguageProcessor
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

    public function execute(DeleteLanguageAction $action)
    {
        $language = $action->getLanguage();

        $this->languageRepository->remove($language);

        return $language;
    }
}
