<?php

namespace Openl10n\Bundle\UserBundle\DataFixtures\ORM;

use Openl10n\Bundle\InfraBundle\DataFixtures\ORM\AbstractFixtureLoader as BaseAbstractFixtureLoader;

abstract class AbstractFixtureLoader extends BaseAbstractFixtureLoader
{
    /**
     * {@inheritdoc}
     */
    protected function getDataPath()
    {
        return realpath(__DIR__.'/../data.yml');
    }
}
