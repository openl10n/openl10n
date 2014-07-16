<?php

namespace Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Translation\Application\Action\DeleteTranslationKeyAction;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteTranslationKeyProcessor
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

    public function execute(DeleteTranslationKeyAction $action)
    {
        $key = $action->getKey();

        $this->translationRepository->removeKey($key);
    }
}
