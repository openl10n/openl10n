<?php

namespace spec\Openl10n\Domain\User\Application\Processor;

use Openl10n\Domain\User\Application\Action\DeleteAccountAction;
use Openl10n\Domain\User\Model\User;
use Openl10n\Domain\User\Repository\UserRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DeleteAccountProcessorSpec extends ObjectBehavior
{
    function let(UserRepository $userRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->beConstructedWith($userRepository, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Domain\User\Application\Processor\DeleteAccountProcessor');
    }

    function it_should_remote_user(
        UserRepository $userRepository,
        EventDispatcherInterface $eventDispatcher,
        User $user,
        DeleteAccountAction $action
    )
    {
        $action->getUser()->willReturn($user);

        $userRepository->remove($user)->shouldBeCalled();

        $this->execute($action);
    }
}
