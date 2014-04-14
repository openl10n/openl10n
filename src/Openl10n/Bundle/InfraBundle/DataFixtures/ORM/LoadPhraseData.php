<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Openl10n\Value\Localization\Locale;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\InfraBundle\Entity\Phrase;

class LoadPhraseData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        return;
        $target1 = new Phrase($this->getReference('key_key1'), Locale::parse('en'));
        $target1
            ->setText('This is a first example')
            ->setApproved(true)
        ;

        $target2 = new Phrase($this->getReference('key_key1'), Locale::parse('fr-FR'));
        $target2
            ->setText('Ceci est un premier exemple')
        ;

        $manager->persist($target1);
        $manager->persist($target2);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
    }
}
