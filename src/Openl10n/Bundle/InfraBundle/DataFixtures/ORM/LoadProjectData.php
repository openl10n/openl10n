<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\InfraBundle\Entity\Project;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;
use Openl10n\Value\String\Slug;
use Openl10n\Value\String\Description;

class LoadProjectData extends AbstractFixtureLoader
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getData('projects') as $slug => $data) {
            $project = $this->createProject($slug, $data);
            $this->addReference('project-'.$slug, $project);
            $manager->persist($project);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }

    private function createProject($slug, array $data)
    {
        return (new Project(new Slug($slug)))
            ->setName(new Name($data['name']))
            ->setDefaultLocale(Locale::parse($data['locale']))
            ->setDescription(new Description($data['description']))
        ;
    }
}
