<?php

namespace spec\Openl10n\Domain\User\Application\Processor;

use Openl10n\Domain\User\Application\Action\RegisterUserAction;
use Openl10n\Domain\User\Value\Email;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;
use Openl10n\Domain\User\Model\Credentials;
use Openl10n\Domain\User\Model\User;
use Openl10n\Domain\User\Repository\CredentialsRepository;
use Openl10n\Domain\User\Repository\UserRepository;
use Openl10n\Domain\User\Value\Username;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class RegisterUserProcessorSpec extends ObjectBehavior
{
    function let(
        UserRepository $userRepository,
        CredentialsRepository $credentialsRepository,
        EncoderFactoryInterface $encoderFactory,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->beConstructedWith(
            $userRepository,
            $credentialsRepository,
            $encoderFactory,
            $eventDispatcher
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Openl10n\Domain\User\Application\Processor\RegisterUserProcessor');
    }

    function it_execute_action(
        UserRepository $userRepository,
        CredentialsRepository $credentialsRepository,
        EncoderFactoryInterface $encoderFactory,
        EventDispatcherInterface $eventDispatcher,
        PasswordEncoderInterface $passwordEncoder,
        User $user,
        Credentials $credentials,
        RegisterUserAction $action
    )
    {
        // Mocks
        $action->getUsername()->willReturn('mattketmo');
        $action->getDisplayName()->willReturn('Matthieu Moquet');
        $action->getEmail()->willReturn('mattketmo@example.org');
        $action->getPassword()->willReturn('super_passw0rd');
        $action->getPreferredLocale()->willReturn('fr_FR');

        $encoderFactory
            ->getEncoder($user)
            ->willReturn($passwordEncoder);

        $passwordEncoder
            ->encodePassword('super_passw0rd', Argument::type('string'))
            ->willReturn('encoded_password==');

        $userRepository
            ->createNew(Argument::exact(new Username('mattketmo')))
            ->willReturn($user);

        $credentialsRepository
            ->createNew($user, 'encoded_password==', Argument::type('string'))
            ->shouldBeCalled()
            ->willReturn($credentials);

        $user
            ->setName(Argument::exact(new Name('Matthieu Moquet')))
            ->shouldBeCalled()
            ->willReturn($user);
        $user
            ->setEmail(Argument::exact(new Email('mattketmo@example.org')))
            ->shouldBeCalled()
            ->willReturn($user);
        $user
            ->setPreferredLocale(Argument::exact(Locale::parse('fr_FR')))
            ->shouldBeCalled()
            ->willReturn($user);

        $userRepository->save($user)->shouldBeCalled();
        $credentialsRepository->save($credentials)->shouldBeCalled();

        $this->execute($action)->shouldReturn($user);
    }
}
