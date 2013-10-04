<?php

namespace Openl10n\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\CoreBundle\Entity\TranslationPhrase;
use Openl10n\Bundle\CoreBundle\Object\Locale;

class LoadTranslationPhraseData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $target1 = new TranslationPhrase($this->getReference('key_key1'), new Locale('en'));
        $target1
            ->setText('This is a first example')
            ->setApproved(true)
        ;

        $target2 = new TranslationPhrase($this->getReference('key_key1'), new Locale('fr-FR'));
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
        return 4;
    }
}
