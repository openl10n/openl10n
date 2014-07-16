<?php

namespace spec\Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Resource\Model\Resource;
use Openl10n\Domain\Translation\Application\Action\CreateTranslationKeyAction;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateTranslationKeyProcessorSpec extends ObjectBehavior
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
        $this->shouldHaveType('Openl10n\Domain\Translation\Application\Processor\CreateTranslationKeyProcessor');
    }

    function it_should_edit_translation(
        TranslationRepository $translationRepository,
        EventDispatcherInterface $eventDispatcher,
        Resource $resource,
        Key $key,
        CreateTranslationKeyAction $action
    )
    {
        $action->getResource()->willReturn($resource);
        $action->getIdentifier()->willReturn('foobar');

        $translationRepository->createNewKey(
            $resource,
            Argument::type('Openl10n\Domain\Translation\Value\StringIdentifier')
        )->willReturn($key);

        $translationRepository->saveKey($key)->shouldBeCalled();

        $this->execute($action)->shouldReturn($key);
    }
}
