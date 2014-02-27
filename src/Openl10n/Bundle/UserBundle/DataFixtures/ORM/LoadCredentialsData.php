<?php

namespace Openl10n\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Openl10n\Bundle\UserBundle\Entity\Credentials;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class LoadCredentialsData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $factory = $this->container->get('security.encoder_factory');

        $user = $this->getReference('user_user');
        $encoder = $factory->getEncoder($user);
        $salt = md5(uniqid(null, true));
        $password = $encoder->encodePassword('user', $salt);

        $userCredentials = new Credentials(
            $this->getReference('user_user'),
            $password,
            $salt
        );

        $user = $this->getReference('user_john');
        $encoder = $factory->getEncoder($user);
        $salt = md5(uniqid(null, true));
        $password = $encoder->encodePassword('johndoe', $salt);

        $johnCredentials = new Credentials(
            $this->getReference('user_john'),
            $password,
            $salt
        );

        $manager->persist($userCredentials);
        $manager->persist($johnCredentials);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
