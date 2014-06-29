<?php

namespace Openl10n\Bundle\UserBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\UserBundle\Entity\Credentials;

class LoadCredentialsData extends AbstractFixtureLoader
{
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData('credentials') as $username => $password) {
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
