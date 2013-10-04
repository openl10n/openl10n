<?php

namespace Openl10n\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Entity\Domain;
use Openl10n\Bundle\CoreBundle\Object\Slug;

class LoadDomainData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
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
