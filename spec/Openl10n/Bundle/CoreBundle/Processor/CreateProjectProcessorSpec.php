<?php

namespace spec\Openl10n\Bundle\CoreBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Action\CreateProjectAction;
use Openl10n\Bundle\CoreBundle\EventDispatcher\ProjectEvents;
use Openl10n\Bundle\CoreBundle\Factory\ProjectFactoryInterface;
use Openl10n\Bundle\CoreBundle\Model\Project;
use Openl10n\Bundle\CoreBundle\Model\ProjectInterface;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateProjectProcessorSpec extends ObjectBehavior
{
    function let(
        ProjectFactoryInterface $projectFactory,
        ObjectManager $projectManager,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->beConstructedWith($projectFactory, $projectManager, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Bundle\CoreBundle\Processor\CreateProjectProcessor');
    }

    function it_should_create_project(
        ProjectInterface $projectMock,
        ProjectFactoryInterface $projectFactory,
        ObjectManager $projectManager,
        EventDispatcherInterface $eventDispatcher
    )
    {
        // Vars
        $slug = new Slug('hello');
        $name = new Name('Hello');
        $locale = new Locale('en_GB');

        $action = new CreateProjectAction();
        $action->name = 'Hello';
        $action->slug = 'hello';
        $action->defaultLocale = 'en_GB';

        // Prepare mock
        $projectMock->getSlug()->willReturn($slug);
        $projectMock->setName($name)->will(function() use ($name) {
            $this->getName()->willReturn($name);
        });
        $projectMock->setDefaultLocale($locale)->will(function() use ($locale) {
            $this->getDefaultLocale()->willReturn($locale);
        });

        $projectFactory
            ->createNew(Argument::type('Openl10n\Bundle\CoreBundle\Object\Slug'))
            ->willReturn($projectMock);

        // Process action
        $project = $this->execute($action);

        // Check project attributes
        $project->getSlug()->shouldBeLike($slug);
        $project->getName()->shouldBeLike($name);
        $project->getDefaultLocale()->shouldBeLike($locale);
        $project->getDefaultLocale()->shouldBeLike($locale);

        // Check object manager has been called
        $projectManager
            ->persist(Argument::type('Openl10n\Bundle\CoreBundle\Model\ProjectInterface'))
            ->shouldBeCalled();
        $projectManager
            ->flush(Argument::type('Openl10n\Bundle\CoreBundle\Model\ProjectInterface'))
            ->shouldBeCalled();

        // Check create event has been dispatched
        $eventDispatcher->dispatch(
            ProjectEvents::CREATE,
            Argument::type('Openl10n\Bundle\CoreBundle\EventDispatcher\Event\ProjectEvent')
        )->shouldBeCalled();
    }
}
