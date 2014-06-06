<?php

namespace Openl10n\Bundle\ApiBundle\Test;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\HttpFoundation\Response;

class WebTestCase extends BaseWebTestCase
{
    protected $client;

    public function getClient()
    {
        if (null === $this->client) {
            $this->client = static::createClient();
        }

        return $this->client;
    }

    protected function assertJsonResponse($response, $statusCode = Response::HTTP_OK)
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );

        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );

        return json_decode($response->getContent(), true);
    }
}
