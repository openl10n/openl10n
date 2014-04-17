<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\InfraBundle\Entity\Domain;
use Openl10n\Value\String\Slug;

class LoadDomainData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        return;

        $basic = new Domain($this->getReference('project_tuto'), new Slug('basic'));
        $advanced = new Domain($this->getReference('project_tuto'), new Slug('advanced'));

        $this->addReference('domain_basic', $basic);
        $this->addReference('domain_advanced', $advanced);

        $manager->persist($basic);
        $manager->persist($advanced);
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
