<?php

namespace Openl10n\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Entity\Project;
use Openl10n\Bundle\CoreBundle\Object\Locale;
use Openl10n\Bundle\CoreBundle\Object\Name;
use Openl10n\Bundle\CoreBundle\Object\Slug;

class LoadProjectData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $tutorial = new Project(new Slug('tutorial'));
        $tutorial
            ->setName(new Name('Tutorial'))
            ->setDefaultLocale(new Locale('en'))
        ;

        $empty = new Project(new Slug('empty'));
        $empty
            ->setName(new Name('Empty Project'))
            ->setDefaultLocale(new Locale('en_GB'))
        ;

        $todelete = new Project(new Slug('todelete'));
        $todelete
            ->setName(new Name('To Delete'))
            ->setDefaultLocale(new Locale('en'))
        ;

        $this->addReference('project_tuto', $tutorial);
        $this->addReference('project_empty', $tutorial);

        $manager->persist($tutorial);
        $manager->persist($empty);
        $manager->persist($todelete);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
