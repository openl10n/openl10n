<?php

namespace Openl10n\Bundle\ApiBundle\Test;

use Symfony\Bundle\FrameworkBundle\Client as BaseClient;

class Client extends BaseClient
{
    /**
     * Database connections of the application.
     */
    protected $isolatedConnections = array();

    /**
     * Start isolation of the data.
     *
     * Begin transactions for each database.
     */
    public function startIsolation()
    {
        $container = $this->getContainer();

        // Isolate Database
        foreach ($container->getParameter('doctrine.connections') as $name => $id) {
            if (!isset($this->isolatedConnections[$name]) || null === $this->isolatedConnections[$name]) {
                $this->isolatedConnections[$name] = $container->get($id);
            } else {
                $this->isolatedConnections[$name]->rollback();
            }

            $this->isolatedConnections[$name]->beginTransaction();
        }
    }

    /**
     * Stop isolation of the data.
     *
     * Rollback every started transations, and close the database connection.
     */
    public function stopIsolation()
    {
        if (null === $this->getContainer()) {
            // no need to stop isolation if container was not built
            return;
        }

        // clear entities managed by the entity manager
        $this->getContainer()->get('doctrine')->getManager()->clear();

        // Rollback transactions
        foreach ($this->isolatedConnections as $name => $connection) {
            if (null !== $connection) {
                try {
                    $connection->rollback();
                    $connection->close();
                } catch (\Exception $e) {
                }
                $this->isolatedConnections[$name] = null;
            }
        }

        $this->getContainer()->get('doctrine')->getConnection()->close();
    }

    /**
     * Set credentials for next HTTP requests.
     *
     * @param string $user
     * @param string $password
     */
    public function setCredentials($user, $password)
    {
        $this->setServerParameter('PHP_AUTH_USER', $user);
        $this->setServerParameter('PHP_AUTH_PW', $password);
    }

    /**
     * Make a JSON HTTP request.
     *
     * Properly set the Accept-Encoding & Content-Type headers.
     *
     * @param string $verb
     * @param string $endpoint
     * @param array  $data
     *
     * @return \Symfony\Component\DomCrawler\Crawler|null
     *
     * @see self::request()
     */
    public function jsonRequest($verb, $endpoint, array $data = array(), array $server = array())
    {
        $data = empty($data) ? null : json_encode($data);
        $server = array_merge(array(
            'CONTENT_TYPE' => 'application/json',
            'HTTP_ACCEPT'  => 'application/json',
            'HTTP_ACCEPT_LANGUAGE' => 'en',
        ), $server);

        return $this->request($verb, $endpoint,
            array(),
            array(),
            $server,
            $data
        );
    }
}
