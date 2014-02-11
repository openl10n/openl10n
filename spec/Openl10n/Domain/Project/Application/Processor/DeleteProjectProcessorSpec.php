<?php

namespace spec\Openl10n\Domain\Project\Application\Processor;

use Openl10n\Domain\Project\Application\Action\DeleteProjectAction;
use Openl10n\Domain\Project\Model\Project;
use Openl10n\Domain\Project\Repository\ProjectRepository;
use Openl10n\Value\String\Slug;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteProjectProcessorSpec extends ObjectBehavior
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
        $this->shouldHaveType('Openl10n\Domain\Project\Application\Processor\DeleteProjectProcessor');
    }

    function it_should_delete_project(
        ProjectRepository $projectRepository,
        EventDispatcherInterface $eventDispatcher,
        Project $project,
        DeleteProjectAction $action
    )
    {
        $action->getProject()->willReturn($project);

        $projectRepository->remove($project)->shouldBeCalled();

        $this->execute($action);
    }
}
