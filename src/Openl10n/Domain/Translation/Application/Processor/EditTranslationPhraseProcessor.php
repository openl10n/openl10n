<?php

namespace Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Translation\Application\Action\EditTranslationPhraseAction;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EditTranslationPhraseProcessor
{
    protected $translationRepository;

    public function __construct(
        TranslationRepository $translationRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->translationRepository = $translationRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(EditTranslationPhraseAction $action)
    {
        $key = $action->getKey();
        $locale = $action->getLocale();

        if (!$key->hasPhrase($locale)) {
            $phrase = $this->translationRepository->createNewPhrase($key, $locale);
        } else {
            $phrase = $key->getPhrase($locale);
        }

        $phrase->setText($action->getText());
        $phrase->setApproved($action->isApproved());

        $this->translationRepository->savePhrase($phrase);

        return $phrase;
    }
}
