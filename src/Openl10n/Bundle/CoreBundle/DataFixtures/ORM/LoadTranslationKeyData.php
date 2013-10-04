<?php

namespace Openl10n\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Entity\TranslationKey;

class LoadTranslationKeyData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $key1 = new TranslationKey($this->getReference('domain_basic'), 'example.key1');
        $key2 = new TranslationKey($this->getReference('domain_basic'), 'example.key2');

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
