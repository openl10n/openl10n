<?php

namespace Openl10n\Bundle\ApiBundle\Tests\Controller;

use Openl10n\Bundle\ApiBundle\Test\WebTestCase;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Slug;
use Symfony\Component\HttpFoundation\Response;

class LanguageControllerTest extends WebTestCase
{
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
