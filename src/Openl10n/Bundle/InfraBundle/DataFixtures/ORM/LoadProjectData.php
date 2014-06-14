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
        $demo = new Project(new Slug('demo'));
        $demo
            ->setName(new Name('Demo'))
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

        $this->addReference('project_demo', $demo);
        $this->addReference('project_empty', $empty);

        $manager->persist($demo);
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
