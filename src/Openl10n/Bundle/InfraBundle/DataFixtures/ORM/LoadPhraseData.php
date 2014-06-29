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
        $data = [
            'foobar-default-example.key1' => [
                'en' => ['text' => 'This is a first example', 'is_approved' => true],
                'fr' => ['text' => 'Ceci est un premier example', 'is_approved' => false],
            ],
            'foobar-default-example.key2' => [
                'en' => ['text' => 'This is a second example', 'is_approved' => false],
            ],
        ];

        foreach ($data as $keyRef => $phrases) {
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
