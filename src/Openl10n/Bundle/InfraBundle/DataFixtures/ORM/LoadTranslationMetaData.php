<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\InfraBundle\Entity\Meta;

class LoadTranslationMetaData extends AbstractFixtureLoader
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData('translation_meta') as $keyRef => $metaData) {
            $meta = $this->createMeta($keyRef, $metaData);
            $this->addReference('translation-meta-'.$keyRef, $meta);
            $manager->persist($meta);
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

    private function createMeta($keyRef, $meta)
    {
        return (new Meta($this->getReference('key-'.$keyRef)))
            ->setDescription($meta['description'])
        ;
    }
}
