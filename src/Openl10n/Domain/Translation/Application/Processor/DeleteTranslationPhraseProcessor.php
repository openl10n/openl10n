<?php

namespace Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Translation\Application\Action\DeleteTranslationPhraseAction;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteTranslationPhraseProcessor
{
    protected $translationRepository;
    protected $eventDispatcher;

    public function __construct(
        TranslationRepository $translationRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->translationRepository = $translationRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(DeleteTranslationPhraseAction $action)
    {
        $phrase = $action->getPhrase();

        $this->translationRepository->removePhrase($phrase);
    }
}
