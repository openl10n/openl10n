<?php

namespace spec\Openl10n\Domain\Project\Application\Processor;

use Openl10n\Domain\Project\Repository\ProjectRepository;
use Openl10n\Value\String\Slug;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Project\Application\Action\CreateProjectAction;
use Openl10n\Domain\Project\Application\Event\CreateProjectEvent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateProjectProcessorSpec extends ObjectBehavior
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
        $this->shouldHaveType('Openl10n\Domain\Project\Application\Processor\CreateProjectProcessor');
    }

    function it_should_create_project(
        ProjectRepository $projectRepository,
        EventDispatcherInterface $eventDispatcher,
        Project $project,
        CreateProjectAction $action
    )
    {
        $action->getName()->willReturn('Foo bar');
        $action->getSlug()->willReturn('foobar');
        $action->getDefaultLocale()->willReturn('fr_FR');
        $action->getDescription()->willReturn('');

        $projectRepository
            ->createNew(Argument::exact(new Slug('foobar')))
            ->willReturn($project);

        $projectRepository->save($project)->shouldBeCalled();

        $eventDispatcher->dispatch(
            CreateProjectEvent::NAME,
            Argument::type('Openl10n\Domain\Project\Application\Event\CreateProjectEvent')
        )->shouldBeCalled();

        $this->execute($action)->shouldReturn($project);
    }
}
