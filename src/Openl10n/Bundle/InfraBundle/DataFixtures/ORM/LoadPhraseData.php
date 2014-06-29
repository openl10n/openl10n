<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\InfraBundle\Entity\Phrase;
use Openl10n\Value\Localization\Locale;

class LoadPhraseData extends AbstractFixtureLoader
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData('translation_phrases') as $keyRef => $phrases) {
            foreach ($phrases as $locale => $phraseData) {
                $phrase = $this->createPhrase($keyRef, $locale, $phraseData);
                $this->addReference('phrase-'.$keyRef.'-'.$locale, $phrase);
                $manager->persist($phrase);
            }
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
    }

    private function createPhrase($keyRef, $locale, $phrase)
    {
        return (new Phrase($this->getReference('key-'.$keyRef), Locale::parse($locale)))
            ->setText($phrase['text'])
            ->setApproved($phrase['is_approved'])
        ;
    }
}
