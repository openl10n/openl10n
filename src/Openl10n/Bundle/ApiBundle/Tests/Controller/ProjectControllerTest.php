<?php

namespace Openl10n\Bundle\ApiBundle\Tests\Controller;

use Openl10n\Bundle\ApiBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProjectControllerTest extends WebTestCase
{
    /**
     * Test projects list response.
     *
     * Example of excepted response:
     *
     *     [
     *       {
     *         "slug": "demo",
     *         "name": "Demo",
     *         "default_locale": "en"
     *       },
     *       {
     *         "slug": "foobar",
     *         "name": "Foobar",
     *         "default_locale": "fr_FR"
     *       }
     *     ]
     */
    public function testGetProjects()
    {
        $client = $this->getClient();
        $client->setCredentials('user', 'user');

        $crawler = $client->jsonRequest('GET', '/api/projects');
        $response = $client->getResponse();
        $data = $this->assertJsonResponse($response, 200);

        $this->assertCount(3, $data, 'There should be 3 projects');
    }

    /**
     * Test demo project response.
     *
     * Example of excepted response:
     *
     *     {
     *       "slug": "demo",
     *       "name": "Demo",
     *       "default_locale": "en"
     *     }
     */
    public function testGetProjectDemo()
    {
        $client = $this->getClient();
        $client->setCredentials('user', 'user');

        $crawler = $client->jsonRequest('GET', '/api/projects/demo');
        $response = $client->getResponse();
        $data = $this->assertJsonResponse(
            $response,
            Response::HTTP_OK,
            'file://'.realpath(__DIR__.'/../Fixtures/schemas/project.json')
        );

        $this->assertEquals('demo', $data->slug, 'Project\'s slug should be "demo"');
        $this->assertEquals('Demo', $data->name, 'Project\'s name should be "Demo"');
        $this->assertEquals('en', $data->default_locale, 'Project\'s default locale should be "en"');
    }
}
