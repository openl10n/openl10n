<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\InfraBundle\Entity\Key;

class LoadKeyData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $key1 = new Key($this->getReference('domain_basic'), 'example.key1');
        $key2 = new Key($this->getReference('domain_basic'), 'example.key2');

        $this->addReference('key_key1', $key1);
        $this->addReference('key_key2', $key2);

        $manager->persist($key1);
        $manager->persist($key2);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }
}
