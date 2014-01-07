<?php

namespace Openl10n\Bundle\UserBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Object\Email;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\UserBundle\Action\EditUserAction;
use Openl10n\Bundle\UserBundle\Entity\User;
use Openl10n\Bundle\UserBundle\Entity\UserCredentials;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EditUserProcessor
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

    public function execute(EditUserAction $action)
    {
        $user = $action->getUser();
        $user
            ->setDisplayName(new Name($action->displayName))
            ->setEmail(new Email($action->email))
            ->setPreferedLocale(new Locale($action->preferedLocale))
        ;
        if (null !== $action->password) {
            $encoder = $this->encoderFactory->getEncoder($user);
            $salt = md5(uniqid(null, true));
            $password = $encoder->encodePassword($action->password, $salt);

            $credentials = $user->getCredentials();
            $credentials->setPassword($password);
            $credentials->setSalt($salt);
            $this->objectManager->persist($credentials);
        }

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        return $user;
    }
}
