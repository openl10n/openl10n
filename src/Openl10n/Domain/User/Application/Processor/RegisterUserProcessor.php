<?php

namespace Openl10n\Domain\User\Application\Processor;

use Openl10n\Domain\User\Application\Action\RegisterUserAction;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;
use Openl10n\Domain\User\Value\Email;
use Openl10n\Domain\User\Value\Username;
use Openl10n\Domain\User\Repository\CredentialsRepository;
use Openl10n\Domain\User\Repository\UserRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class RegisterUserProcessor
{
    protected $userRepository;
    protected $credentialsRepository;
    protected $encoderFactory;
    protected $eventDispatcher;

    public function __construct(
        UserRepository $userRepository,
        CredentialsRepository $credentialsRepository,
        EncoderFactoryInterface $encoderFactory,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->userRepository = $userRepository;
        $this->credentialsRepository = $credentialsRepository;
        $this->encoderFactory = $encoderFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(RegisterUserAction $action)
    {
        $username = new Username($action->getUsername());
        $password = $action->getPassword();
        $email = new Email($action->getEmail());
        $displayName = new Name($action->getDisplayName());
        $preferedLocale = Locale::parse($action->getPreferedLocale());

        $user = $this->userRepository->createNew($username);
        $user
            ->setName($displayName)
            ->setEmail($email)
            ->setPreferedLocale($preferedLocale);

        $encoder = $this->encoderFactory->getEncoder($user);
        $salt = md5(uniqid(null, true));
        $password = $encoder->encodePassword($password, $salt);

        $credentials = $this->credentialsRepository->createNew($user, $password, $salt);

        $this->userRepository->save($user);
        $this->credentialsRepository->save($credentials);

        return $user;
    }
}
