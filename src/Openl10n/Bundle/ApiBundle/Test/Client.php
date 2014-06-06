<?php

namespace Openl10n\Bundle\ApiBundle\Test;

use Symfony\Bundle\FrameworkBundle\Client as BaseClient;

class Client extends BaseClient
{
    public function setCredentials($user, $password)
    {
        $this->setServerParameter('PHP_AUTH_USER', $user);
        $this->setServerParameter('PHP_AUTH_PW', $password);
    }

    public function jsonRequest($verb, $endpoint, array $data = array())
    {
        $data = empty($data) ? null : json_encode($data);

        return $this->request($verb, $endpoint,
            array(),
            array(),
            array(
                'HTTP_ACCEPT'  => 'application/json',
                'CONTENT_TYPE' => 'application/json'
            ),
            $data
        );
    }
}
