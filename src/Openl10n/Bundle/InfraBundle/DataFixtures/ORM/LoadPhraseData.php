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
        $target1a = new Phrase($this->getReference('key_key1'), Locale::parse('en'));
        $target1a
            ->setText('This is a first example')
            ->setApproved(true)
        ;


        $target1b = new Phrase($this->getReference('key_key1'), Locale::parse('fr-FR'));
        $target1b
            ->setText('Ceci est un premier example')
            ->setApproved(false)
        ;

        $target2 = new Phrase($this->getReference('key_key2'), Locale::parse('en'));
        $target2
            ->setText('This is a second example')
        ;


        $manager->persist($target1a);
        $manager->persist($target1b);
        $manager->persist($target2);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
    }
}
