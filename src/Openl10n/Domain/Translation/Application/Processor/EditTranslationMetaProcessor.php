<?php

namespace Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Translation\Application\Action\EditTranslationMetaAction;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EditTranslationMetaProcessor
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

    public function execute(EditTranslationMetaAction $action)
    {
        $key = $action->getKey();
        $meta = $key->getMeta();

        $description = $action->getDescription();
        $meta->setDescription($description);

        $this->translationRepository->saveMeta($meta);

        return $meta;
    }
}
