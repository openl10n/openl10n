<?php

namespace Openl10n\Bundle\ApiBundle\Tests\Controller;

use Openl10n\Bundle\ApiBundle\Test\WebTestCase;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Slug;
use Symfony\Component\HttpFoundation\Response;

class ProjectControllerTest extends WebTestCase
{
    /**
     * Test projects list response.
     */
    public function testGetProjectsList()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/projects');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK
        );

        $this->assertCount(2, $data, 'There should be 2 projects');
    }

    /**
     * Test demo project response.
     */
    public function testGetProject()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/projects/foobar');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK,
            'project'
        );

        $this->assertEquals('foobar', $data->slug);
        $this->assertEquals('Foobar', $data->name);
        $this->assertEquals('en', $data->default_locale);
    }

    /**
     * Test to get a non existing project.
     */
    public function testGetProjectNotFound()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/projects/not-found');

        $this->assertJsonResponse(
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
        $this->assertEquals((string) $project->getName(), 'New Project');
        $this->assertEquals((string) $project->getDefaultLocale(), 'en');
    }

    /**
     * Test to create an existing project (identified by slug).
     */
    public function testCreateExistingProject()
    {
        $client = $this->getClient();
        $client->jsonRequest('POST', '/api/projects', [
            'name' => 'New Project',
            'slug' => 'foobar',
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
        $client->jsonRequest('PUT', '/api/projects/foobar', [
            'name' => 'Barbaz',
            'default_locale' => 'fr',
        ]);

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NO_CONTENT
        );

        // Ensure project has been created
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug('foobar'));

        $this->assertNotNull($project, 'Project "foobar" should exist');
        $this->assertEquals((string) $project->getName(), 'Barbaz');
        $this->assertEquals((string) $project->getDefaultLocale(), 'fr');
    }

    /**
     * Test to delete an existing project.
     */
    public function testDeleteProject()
    {
        $client = $this->getClient();
        $client->jsonRequest('DELETE', '/api/projects/empty');

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NO_CONTENT
        );

        $this->assertNull(
            $this->get('openl10n.repository.project')->findOneBySlug(new Slug('empty')),
            'Project "todelete" should not exist'
        );
    }

    /**
     * Test to get project languages.
     */
    public function testGetProjectLanguagesList()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/projects/foobar/languages');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK
        );

        $this->assertCount(4, $data, 'There should be 4 languages in "foobar" projects');
    }

    /**
     * Test to get a project language.
     */
    public function testGetProjectLanguage()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/projects/foobar/languages/en');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK,
            'language'
        );

        $this->assertEquals('en', $data->locale);
    }

    /**
     * Test to get a non existing project.
     */
    public function testGetProjectLanguageNotFound()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/projects/foobar/languages/pt_BR');

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * Test to create a new project.
     */
    public function testCreateNewProjectLanguage()
    {
        $client = $this->getClient();
        $client->jsonRequest('POST', '/api/projects/foobar/languages', [
            'locale' => 'pt_BR'
        ]);

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_CREATED
        );

        // Ensure project has been created
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug('foobar'));
        $language = $this->get('openl10n.repository.language')->findOneByProject($project, Locale::parse('pt-BR'));

        $this->assertNotNull($language, 'Language "pt-BR" should exist in project "foobar"');
    }

    /**
     * Test to create a new project.
     */
    public function testCreateExistingProjectLanguage()
    {
        $this->markTestIncomplete();
    }

    /**
     * Test to delete an existing project.
     */
    public function testDeleteProjectLanguage()
    {
        $client = $this->getClient();
        $client->jsonRequest('DELETE', '/api/projects/foobar/languages/fr');

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NO_CONTENT
        );

        // Ensure project has been created
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug('foobar'));
        $language = $this->get('openl10n.repository.language')->findOneByProject($project, Locale::parse('fr'));

        $this->assertNull($language, 'Language "fr" should not exist after a DELETE in project "foobar"');
    }

    /**
     * Test to delete project default language.
     */
    public function testDeleteProjectDefaultLanguageMustFail()
    {
        $client = $this->getClient();
        $client->jsonRequest('DELETE', '/api/projects/foobar/languages/en');

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_BAD_REQUEST
        );
    }
}
