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
        $client = $this->getClient();
        $client->jsonRequest('POST', '/api/projects', [
            'name' => 'New Project',
            'slug' => 'new-project',
            'default_locale' => 'en',
        ]);

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_CREATED
        );

        // Ensure project has been created
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug('new-project'));
        $this->assertNotNull($project, 'Project "new-project" should exist');
        $this->assertEquals((string) $project->getName(), 'New Project', 'Project\'s name should be "New Project"');
        $this->assertEquals((string) $project->getDefaultLocale(), 'en', 'Project\'s locale should be "en"');
    }

    /**
     * Test to create an existing project (identified by slug).
     */
    public function testCreateExistingProject()
    {
        $client = $this->getClient();
        $client->jsonRequest('POST', '/api/projects', [
            'name' => 'New Project',
            'slug' => 'demo',
            'default_locale' => 'en',
        ]);

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * Test to update an existing project.
     */
    public function testUpdateProject()
    {
        $client = $this->getClient();
        $client->jsonRequest('PUT', '/api/projects/demo', [
            'name' => 'Foobar',
            'default_locale' => 'fr',
        ]);

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NO_CONTENT
        );

        // Ensure project has been created
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug('demo'));
        $this->assertNotNull($project, 'Project "demo" should exist');
        $this->assertEquals((string) $project->getName(), 'Foobar', 'Project\'s name should be "Foobar"');
        $this->assertEquals((string) $project->getDefaultLocale(), 'fr', 'Project\'s locale should be "fr"');
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
