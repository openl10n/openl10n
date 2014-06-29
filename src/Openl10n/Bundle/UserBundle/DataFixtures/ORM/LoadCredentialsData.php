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
        $credentials = [
            'user' => 'userpass',
        ];

        foreach ($credentials as $username => $password) {
            $credential = $this->createCredentials($username, $password);
            $manager->persist($credential);
        }

        $manager->persist($credential);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    private function createCredentials($username, $password)
    {
        $user = $this->getReference('user-'.$username);

        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        $salt = md5(uniqid(null, true));
        $password = $encoder->encodePassword($password, $salt);

        return new Credentials($user, $password, $salt);
    }
}
