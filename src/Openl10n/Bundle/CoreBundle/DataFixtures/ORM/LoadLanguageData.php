<?php

namespace Openl10n\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Entity\Language;
use Openl10n\Bundle\CoreBundle\Object\Locale;

class LoadLanguageData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $tutoEn = new Language($this->getReference('project_tuto'), new Locale('en'));
        $tutoFrFr = new Language($this->getReference('project_tuto'), new Locale('fr_FR'));
        $tutoItIt = new Language($this->getReference('project_tuto'), new Locale('it_IT'));

        $emptyEnGb = new Language($this->getReference('project_empty'), new Locale('en_GB'));

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
