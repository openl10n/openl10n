<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;
use Openl10n\Value\String\Slug;
use Openl10n\Bundle\InfraBundle\Entity\Project;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

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
            ->setDefaultLocale(Locale::parse('en'))
        ;

        $empty = new Project(new Slug('empty'));
        $empty
            ->setName(new Name('Empty Project'))
            ->setDefaultLocale(Locale::parse('en_GB'))
        ;

        $todelete = new Project(new Slug('todelete'));
        $todelete
            ->setName(new Name('To Delete'))
            ->setDefaultLocale(Locale::parse('en'))
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
