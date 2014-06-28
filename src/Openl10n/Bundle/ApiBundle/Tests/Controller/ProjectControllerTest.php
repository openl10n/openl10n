<?php

namespace Openl10n\Bundle\ApiBundle\Tests\Controller;

use Openl10n\Bundle\ApiBundle\Test\WebTestCase;
use Openl10n\Value\String\Slug;
use Symfony\Component\HttpFoundation\Response;

class ProjectControllerTest extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();

        $client = $this->getClient();
        $client->setCredentials('user', 'user');
    }

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
    public function testGetProjectsList()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/projects');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK
        );

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
    public function testGetProject()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/projects/demo');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK,
            'project'
        );

        $this->assertEquals('demo', $data->slug, 'Project\'s slug should be "demo"');
        $this->assertEquals('Demo', $data->name, 'Project\'s name should be "Demo"');
        $this->assertEquals('en', $data->default_locale, 'Project\'s default locale should be "en"');
    }

    /**
     * Test to get a non existing project.
     */
    public function testGetProjectNotFound()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/projects/not-found');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Test to create a new project.
     */
    public function testCreateNewProject()
    {
        $this->markTestIncomplete();
    }

    /**
     * Test to create an existing project (identified by slug).
     */
    public function testCreateExistingProject()
    {
        $this->markTestIncomplete();
    }

    /**
     * Test to update an existing project.
     */
    public function testUpdateProject()
    {
        $this->markTestIncomplete();
    }

    /**
     * Test to delete an existing project.
     */
    public function testDeleteProject()
    {
        $client = $this->getClient();
        $client->jsonRequest('DELETE', '/api/projects/todelete');

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NO_CONTENT
        );

        $this->assertNull(
            $this->get('openl10n.repository.project')->findOneBySlug(new Slug('todelete')),
            'Project "todelete" should not exist'
        );
    }
}
