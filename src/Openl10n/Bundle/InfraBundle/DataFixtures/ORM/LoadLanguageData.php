<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Openl10n\Value\Localization\Locale;
use Openl10n\Bundle\InfraBundle\Entity\Language;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLanguageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $tutoEn = new Language($this->getReference('project_demo'), Locale::parse('en'));
        $tutoFrFr = new Language($this->getReference('project_demo'), Locale::parse('fr_FR'));
        $tutoItIt = new Language($this->getReference('project_demo'), Locale::parse('it_IT'));

        $emptyEnGb = new Language($this->getReference('project_empty'), Locale::parse('en_GB'));

        $manager->persist($tutoEn);
        $manager->persist($tutoFrFr);
        $manager->persist($tutoItIt);
        $manager->persist($emptyEnGb);
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
