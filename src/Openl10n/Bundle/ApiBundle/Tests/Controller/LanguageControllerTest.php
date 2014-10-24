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
    public function testGetLanguagesList()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/languages');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK
        );

        $this->assertGreaterThanOrEqual(150, $data, 'There should be at least 150 languages returned');
        $this->assertNotNull($data[0]->locale);
        $this->assertNotNull($data[0]->name);
    }

    /**
     * Test to get a project language.
     */
    public function testGetLanguage()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/languages/en');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK,
            'language'
        );

        $this->assertEquals('en', $data->locale);
        $this->assertEquals('English', $data->name);
    }
}
