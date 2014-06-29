<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\InfraBundle\Entity\Key;
use Openl10n\Domain\Translation\Value\StringIdentifier;

class LoadKeyData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            'foobar-default' => [
                'example.key1',
                'example.key2',
            ]
        ];

        foreach ($data as $resource => $keys) {
            foreach ($keys as $keyId) {
                $key = $this->createKey($resource, $keyId);
                $this->addReference('key-'.$resource.'-'.$keyId, $key);
                $manager->persist($key);
            }
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }

    private function createKey($resource, $keyId)
    {
        return new Key(
            $this->getReference('resource-'.$resource),
            new StringIdentifier($keyId)
        );
    }
}
