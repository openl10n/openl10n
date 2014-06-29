<?php

namespace spec\Openl10n\Domain\Project\Application\Processor;

use Openl10n\Domain\Project\Application\Action\CreateLanguageAction;
use Openl10n\Value\Localization\Locale;
use Openl10n\Domain\Project\Model\Language;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Project\Repository\LanguageRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateLanguageProcessorSpec extends ObjectBehavior
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
        $this->shouldHaveType('Openl10n\Domain\Project\Application\Processor\CreateLanguageProcessor');
    }

    function it_should_create_language(
        LanguageRepository $languageRepository,
        EventDispatcherInterface $eventDispatcher,
        Project $project,
        Language $language,
        CreateLanguageAction $action
    )
    {
        $action->getProject()->willReturn($project);
        $action->getLocale()->willReturn('fr_FR');

        $languageRepository
            ->createNew($project, Argument::exact(Locale::parse('fr_FR')))
            ->willReturn($language);

        $languageRepository->save($language)->shouldBeCalled();

        $this->execute($action)->shouldReturn($language);
    }
}
