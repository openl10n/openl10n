<?php

namespace Openl10n\Bundle\ApiBundle\Tests\Controller;

use Openl10n\Bundle\ApiBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function iShouldGetProjectsList()
    {
        $client = $this->getClient();
        $client->setCredentials('user', 'user');

        // API call
        $crawler = $client->jsonRequest('GET', '/api/projects');
        $response = $client->getResponse();

        // Parse JSON response
        $this->assertJsonResponse($response, 200);
        $content = json_decode($response->getContent(), true);

        // Assert content
        $this->assertCount(3, $content, 'There should be 3 projects');
    }

    /**
     * @test
     */
    public function iShouldGetProjectDemo()
    {
        $client = $this->getClient();
        $client->setCredentials('user', 'user');

        // API call
        $crawler = $client->jsonRequest('GET', '/api/projects/demo');
        $response = $client->getResponse();

        // Parse JSON response
        $this->assertJsonResponse($response, 200);
        $content = json_decode($response->getContent(), true);

        // Assert content
        $this->assertArrayHasKey('slug', $content, 'Project has a slug');
        $this->assertArrayHasKey('name', $content, 'Project has a name');
        $this->assertEquals('demo', $content['slug'], 'Project\'s slug should be "demo"');
        $this->assertEquals('Demo', $content['name'], 'Project\'s name should be "Demo"');
    }
}
