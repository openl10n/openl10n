<?php

namespace Openl10n\Bundle\ApiBundle\Test;

use JsonSchema;
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

    protected function assertJsonResponse($response, $statusCode = Response::HTTP_OK, $schemaUri = null)
    {
        // Assert HTTP response status code
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );

        // Assert response is JSON content-type
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );

        // Parse the response body
        $data = json_decode($response->getContent());

        // Validate JSON data with given schema
        if (null !== $schemaUri) {
            $retriever = new JsonSchema\Uri\UriRetriever;
            $schema = $retriever->retrieve($schemaUri);

            $validator = new JsonSchema\Validator();
            $validator->check($data, $schema);

            if (!$validator->isValid()) {
                $errorMessage = 'JSON response does not validate the schema';
                foreach ($validator->getErrors() as $error) {
                    $errorMessage .= sprintf("\n[%s] %s", $error['property'], $error['message']);
                }

                $this->fail($errorMessage);
            }
        }

        return $data;
    }
}
