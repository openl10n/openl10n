<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Name;
use Openl10n\Value\String\Slug;
use Openl10n\Bundle\InfraBundle\Entity\Project;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProjectData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $projects = [
            'foobar' => ['name' => 'Foobar', 'locale' => 'en'],
            'empty'  => ['name' => 'Empty', 'locale' => 'fr-FR'],
        ];

        foreach ($projects as $slug => $data) {
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
        ;
    }
}
