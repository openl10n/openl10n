<?php

namespace spec\Openl10n\Domain\Project\Application\Processor;

use Openl10n\Domain\Project\Application\Action\DeleteLanguageAction;
use Openl10n\Domain\Project\Model\Language;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Project\Repository\LanguageRepository;
use Openl10n\Value\String\Slug;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteLanguageProcessorSpec extends ObjectBehavior
{
    function let(
        LanguageRepository $languageRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->beConstructedWith($languageRepository, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Domain\Project\Application\Processor\DeleteLanguageProcessor');
    }

    function it_should_delete_language(
        LanguageRepository $languageRepository,
        EventDispatcherInterface $eventDispatcher,
        Language $language,
        DeleteLanguageAction $action
    )
    {
        $action->getLanguage()->willReturn($language);

        $languageRepository->remove($language)->shouldBeCalled();

        $this->execute($action);
    }
}
