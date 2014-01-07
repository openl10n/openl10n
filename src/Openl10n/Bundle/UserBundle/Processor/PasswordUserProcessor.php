<?php

namespace Openl10n\Bundle\UserBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\UserBundle\Action\PasswordUserAction;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class PasswordUserProcessor
{
    protected $encoderFactory;
    protected $objectManager;

    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        ObjectManager $objectManager,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->encoderFactory = $encoderFactory;
        $this->objectManager = $objectManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(PasswordUserAction $action)
    {
        $user = $action->getUser();
        $credentials = $user->getCredentials();
        $encoder = $this->encoderFactory->getEncoder($user);
        $salt = md5(uniqid(null, true));

        $password = $encoder->encodePassword($action->newPassword, $salt);
        $credentials->setPassword($password);
        $credentials->setSalt($salt);

        $this->objectManager->persist($credentials);
        $this->objectManager->flush();

        return $user;
    }
}
