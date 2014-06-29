<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Openl10n\Bundle\InfraBundle\Entity\Resource;
use Openl10n\Domain\Resource\Value\Pathname;

class LoadResourceData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            'foobar' => [
                'default' => 'locales/default.en.yml',
            ],
        ];

        foreach ($data as $project => $resources) {
            foreach ($resources as $id => $pathname) {
                $resource = $this->createResource($project, $pathname);
                $this->addReference('resource-'.$project.'-'.$id, $resource);
                $manager->persist($resource);
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

    private function createResource($project, $pathname)
    {
        return new Resource(
            $this->getReference('project-'.$project),
            new Pathname($pathname)
        );
    }
}
