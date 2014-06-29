<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\InfraBundle\Entity\Language;
use Openl10n\Value\Localization\Locale;

class LoadLanguageData extends AbstractFixtureLoader
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData('languages') as $project => $locales) {
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
