<?php

namespace spec\Openl10n\Domain\User\Application\Processor;

use Openl10n\Domain\User\Application\Action\EditProfileAction;
use Openl10n\Domain\User\Model\User;
use Openl10n\Domain\User\Repository\UserRepository;
use Openl10n\Domain\User\Value\Email;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EditProfileProcessorSpec extends ObjectBehavior
{
    function let(UserRepository $userRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->beConstructedWith($userRepository, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Domain\User\Application\Processor\EditProfileProcessor');
    }

    function it_can_edit_user_profile(
        UserRepository $userRepository,
        EventDispatcherInterface $eventDispatcher,
        User $user,
        EditProfileAction $action
    )
    {
        $action->getUser()->willReturn($user);
        $action->getDisplayName()->willReturn('John Doe');
        $action->getPreferedLocale()->willReturn('fr_FR');
        $action->getEmail()->willReturn('john.doe@example.org');

        $user
            ->setName(Argument::exact(new Name('John Doe')))
            ->willReturn($user)
            ->shouldBeCalled();
        $user
            ->setEmail(Argument::exact(new Email('john.doe@example.org')))
            ->willReturn($user)
            ->shouldBeCalled();
        $user
            ->setPreferedLocale(Argument::exact(Locale::parse('fr_Fr')))
            ->willReturn($user)
            ->shouldBeCalled();

        $userRepository->save($user)->shouldBeCalled();

        $this->execute($action);
    }
}
