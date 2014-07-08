<?php

namespace Openl10n\Domain\User\Application\Processor;

use Openl10n\Domain\User\Application\Action\ChangePasswordAction;
use Openl10n\Domain\User\Repository\CredentialsRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class ChangePasswordProcessor
{
    protected $credentialsRepository;
    protected $encoderFactory;
    protected $eventDispatcher;

    public function __construct(
        CredentialsRepository $credentialsRepository,
        EncoderFactoryInterface $encoderFactory,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->credentialsRepository = $credentialsRepository;
        $this->encoderFactory = $encoderFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(ChangePasswordAction $action)
    {
        $user = $action->getUser();
        $newPassword = $action->getNewPassword();

        $encoder = $this->encoderFactory->getEncoder($user);
        $salt = md5(uniqid(null, true));
        $password = $encoder->encodePassword($newPassword, $salt);

        $newCredentials = $this->credentialsRepository->createNew($user, $password, $salt);
        $oldCredentials = $this->credentialsRepository->findOneByUser($user);

        if (null === $oldCredentials) {
            throw new \RuntimeException(sprintf(
                'Unable to retrieve old credentials for user %s',
                $user->getUsername()
            ));
        }

        $this->credentialsRepository->remove($oldCredentials);
        $this->credentialsRepository->save($newCredentials);
    }
}
