<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\InfraBundle\Entity\Resource;
use Openl10n\Domain\Translation\Value\Pathname;
use Openl10n\Value\String\Slug;

class LoadResourceData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $res = new Resource(
            $this->getReference('project_demo'),
            new Pathname('locales/default.en.yml')
        );

        $this->addReference('resource_default', $res);

        $manager->persist($res);
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
