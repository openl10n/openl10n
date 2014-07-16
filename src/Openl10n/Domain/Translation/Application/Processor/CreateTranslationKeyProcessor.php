<?php

namespace Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Translation\Application\Action\CreateTranslationKeyAction;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use Openl10n\Domain\Translation\Value\StringIdentifier;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateTranslationKeyProcessor
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

    public function execute(CreateTranslationKeyAction $action)
    {
        $resource = $action->getResource();
        $identifier = new StringIdentifier($action->getIdentifier());

        $key = $this->translationRepository->createNewKey($resource, $identifier);

        $this->translationRepository->saveKey($key);

        return $key;
    }
}
