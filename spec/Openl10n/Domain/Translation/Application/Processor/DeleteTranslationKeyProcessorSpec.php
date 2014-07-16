<?php

namespace spec\Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Translation\Application\Action\DeleteTranslationKeyAction;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteTranslationKeyProcessorSpec extends ObjectBehavior
{
    function let(
        TranslationRepository $translationRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->beConstructedWith($translationRepository, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Domain\Translation\Application\Processor\DeleteTranslationKeyProcessor');
    }

    function it_should_edit_translation(
        TranslationRepository $translationRepository,
        EventDispatcherInterface $eventDispatcher,
        Key $key,
        DeleteTranslationKeyAction $action
    )
    {
        $action->getKey()->willReturn($key);

        $translationRepository->removeKey($key)->shouldBeCalled();

        $this->execute($action);
    }
}
