<?php

namespace Openl10n\Bundle\ApiBundle\Tests\Controller;

use Openl10n\Bundle\ApiBundle\Test\WebTestCase;

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
        $content = $this->assertJsonResponse($response, 200);

        $this->assertCount(3, $content, 'There should be 3 projects');
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
        $content = $this->assertJsonResponse($response, 200);

        $this->assertArrayHasKey('slug', $content, 'Project has a slug');
        $this->assertArrayHasKey('name', $content, 'Project has a name');
        $this->assertArrayHasKey('default_locale', $content, 'Project has a default_locale');

        $this->assertEquals('demo', $content['slug'], 'Project\'s slug should be "demo"');
        $this->assertEquals('Demo', $content['name'], 'Project\'s name should be "Demo"');
        $this->assertEquals('en', $content['default_locale'], 'Project\'s default locale should be "en"');
    }
}
