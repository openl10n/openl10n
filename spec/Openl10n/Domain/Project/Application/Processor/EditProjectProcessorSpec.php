<?php

namespace spec\Openl10n\Domain\Project\Application\Processor;

use Openl10n\Domain\Project\Repository\ProjectRepository;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;
use Openl10n\Value\String\Description;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Project\Application\Action\EditProjectAction;
use Openl10n\Domain\Project\Application\Event\EditProjectEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EditProjectProcessorSpec extends ObjectBehavior
{
    function let(
        ProjectRepository $projectRepository,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->beConstructedWith($projectRepository, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Domain\Project\Application\Processor\EditProjectProcessor');
    }

    function it_should_edit_project(
        ProjectRepository $projectRepository,
        EventDispatcherInterface $eventDispatcher,
        Project $project,
        EditProjectAction $action
    )
    {
        $action->getProject()->willReturn($project);
        $action->getName()->willReturn('Foo Bar');
        $action->getDefaultLocale()->willReturn('fr_FR');
        $action->getDescription()->willReturn('Description');

        $project
            ->setName(Argument::exact(new Name('Foo Bar')))
            ->shouldBeCalled();
        $project
            ->setDefaultLocale(Argument::exact(Locale::parse('fr_FR')))
            ->shouldBeCalled();
        $project
            ->setDescription(Argument::exact(new Description('Description')))
            ->shouldBeCalled();

        $projectRepository->save($project)->shouldBeCalled();

        $eventDispatcher->dispatch(
            EditProjectEvent::NAME,
            Argument::type('Openl10n\Domain\Project\Application\Event\EditProjectEvent')
        )->shouldBeCalled();

        $this->execute($action)->shouldReturn($project);
    }
}
