<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\InfraBundle\Entity\Resource;
use Openl10n\Value\String\Slug;

class LoadResourceData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $res1 = new Resource(
            $this->getReference('domain_basic'),
            'locales/basic.%locale%.yml'
        );

        $this->addReference('domain_basic_res1', $res1);

        $manager->persist($res1);
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
