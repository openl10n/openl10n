<?php

namespace Openl10n\Bundle\UserBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Object\Email;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;
use Openl10n\Bundle\UserBundle\Action\CreateUserAction;
use Openl10n\Bundle\UserBundle\Entity\User;
use Openl10n\Bundle\UserBundle\Entity\UserCredentials;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class CreateUserProcessor
{
    protected $encoderFactory;
    protected $objectManager;

    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        ObjectManager $objectManager
    )
    {
        $this->encoderFactory = $encoderFactory;
        $this->objectManager = $objectManager;
    }

    public function execute(CreateUserAction $action)
    {
        $user = new User(new Slug($action->username));
        $user
            ->setDisplayName(new Name($action->displayName))
            ->setEmail(new Email($action->email))
            ->setPreferedLocale(new Locale($action->preferedLocale))
        ;

        $encoder = $this->encoderFactory->getEncoder($user);
        $salt = md5(uniqid(null, true));
        $password = $encoder->encodePassword($action->password, $salt);

        $credentials = new UserCredentials($user, $password, $salt);

        $this->objectManager->persist($user);
        $this->objectManager->persist($credentials);
        $this->objectManager->flush();

        return $user;
    }
}
