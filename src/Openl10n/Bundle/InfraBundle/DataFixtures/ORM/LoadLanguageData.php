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
        $data = [
            'foobar' => ['en', 'es', 'fr', 'it'],
            'empty'  => ['fr-FR'],
        ];

        foreach ($data as $project => $locales) {
            foreach ($locales as $locale) {
                $language = $this->createLanguage($project, $locale);
                $manager->persist($language);
            }
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }

    private function createLanguage($project, $locale)
    {
        return new Language(
            $this->getReference('project-'.$project),
            Locale::parse($locale)
        );
    }
}
