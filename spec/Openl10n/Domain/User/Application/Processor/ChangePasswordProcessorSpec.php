<?php

namespace spec\Openl10n\Domain\User\Application\Processor;

use Openl10n\Domain\User\Application\Action\ChangePasswordAction;
use Openl10n\Domain\User\Model\Credentials;
use Openl10n\Domain\User\Model\User;
use Openl10n\Domain\User\Repository\CredentialsRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class ChangePasswordProcessorSpec extends ObjectBehavior
{
    public function let(
        CredentialsRepository $credentialsRepository,
        EncoderFactoryInterface $encoderFactory,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->beConstructedWith($credentialsRepository, $encoderFactory, $eventDispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Domain\User\Application\Processor\ChangePasswordProcessor');
    }

    function it_should_change_user_password(
        CredentialsRepository $credentialsRepository,
        EncoderFactoryInterface $encoderFactory,
        EventDispatcherInterface $eventDispatcher,
        PasswordEncoderInterface $passwordEncoder,
        User $user,
        Credentials $oldCredentials,
        Credentials $newCredentials,
        ChangePasswordAction $action
    )
    {
        // Mocks
        $action->getUser()->willReturn($user);
        $action->getOldPassword()->willReturn('old_p4ssw0rd');
        $action->getNewPassword()->willReturn('new_p4ssw0rd');

        $encoderFactory
            ->getEncoder($user)
            ->willReturn($passwordEncoder);

        $passwordEncoder
            ->encodePassword('new_p4ssw0rd', Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn('encoded_password==');

        // Old credentials should be remove
        $credentialsRepository
            ->findOneByUser($user)
            ->willReturn($oldCredentials);
        $credentialsRepository
            ->remove($oldCredentials)
            ->shouldBeCalled();

        // New encoded password should be saved
        $credentialsRepository
            ->createNew($user, 'encoded_password==', Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($newCredentials);
        $credentialsRepository
            ->save($newCredentials)
            ->shouldBeCalled();

        $this->execute($action);
    }
}
