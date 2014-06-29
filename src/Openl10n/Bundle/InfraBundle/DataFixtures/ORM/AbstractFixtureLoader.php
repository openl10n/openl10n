<?php

namespace Openl10n\Bundle\InfraBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Parser;

abstract class AbstractFixtureLoader extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * Parse data from Yaml file and return the requested section.
     *
     * @param string $section The section to return
     *
     * @return array Data as array containing scalar values
     */
    protected function getData($section)
    {
        if (null === $this->data) {
            $yaml = new Parser();
            $this->data = $yaml->parse(file_get_contents($this->getDataPath()));
        }

        if (!isset($this->data[$section])) {
            throw new \RuntimeException(sprintf('There is no section "%s" in current data fixtures', $section));
        }

        return $this->data[$section];
    }

    /**
     * Return fullpath to the Yaml data file.
     *
     * @return string The data pathname
     */
    protected function getDataPath()
    {
        return realpath(__DIR__.'/../data.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
