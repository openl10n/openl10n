<?php

namespace spec\Openl10n\Domain\Translation\Application\Processor;

use Openl10n\Domain\Translation\Application\Action\EditTranslationPhraseAction;
use Openl10n\Value\Localization\Locale;
use Openl10n\Domain\Translation\Model\Key;
use Openl10n\Domain\Translation\Model\Phrase;
use Openl10n\Domain\Translation\Repository\TranslationRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EditTranslationPhraseProcessorSpec extends ObjectBehavior
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
        $this->shouldHaveType('Openl10n\Domain\Translation\Application\Processor\EditTranslationPhraseProcessor');
    }

    function it_should_edit_translation(
        TranslationRepository $translationRepository,
        EventDispatcherInterface $eventDispatcher,
        Key $key,
        Phrase $phrase,
        EditTranslationPhraseAction $action
    )
    {
        $locale = Locale::parse('en');

        $action->getKey()->willReturn($key);
        $action->getLocale()->willReturn($locale);
        $action->getText()->willReturn('foobar');
        $action->isApproved()->willReturn(true);

        $key->hasPhrase($locale)->willReturn(true);
        $key->getPhrase($locale)->willReturn($phrase);

        $phrase->setText('foobar')->shouldBeCalled();
        $phrase->setApproved(true)->shouldBeCalled();

        $translationRepository->savePhrase($phrase)->shouldBeCalled();

        $this->execute($action)->shouldReturn($phrase);
    }
}
