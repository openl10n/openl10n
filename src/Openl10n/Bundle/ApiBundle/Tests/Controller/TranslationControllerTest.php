<?php

namespace Openl10n\Bundle\ApiBundle\Tests\Controller;

use Openl10n\Bundle\ApiBundle\Test\WebTestCase;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Slug;
use Symfony\Component\HttpFoundation\Response;

class TranslationControllerTest extends WebTestCase
{
    public function testGetTranslationsListByProject()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testGetTranslation()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/translations/1');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK,
            'translation'
        );

        $this->assertEquals('example.key1', $data->identifier);
    }

    public function testCreateNewTranslation()
    {
        $this->markTestIncomplete('Not implemented yet');
    }

    public function testDeleteTranslation()
    {
        $client = $this->getClient();
        $client->jsonRequest('DELETE', '/api/translations/1');

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NO_CONTENT
        );

        $this->assertNull(
            $this->get('openl10n.repository.translation')->findOneById(1),
            'Translation 1 should not exist anymore'
        );
    }

    public function testGetTranslationPhrasesList()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/translations/1/phrases');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK,
            'translation'
        );

        $this->assertEquals('example.key1', $data->identifier);
        $this->assertCount(2, (array) $data->phrases);
    }

    public function testGetTranslationPhrase()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/translations/1/phrases/en');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK,
            'translation_phrase'
        );

        $this->assertEquals('en', $data->locale);
        $this->assertEquals('This is a first example', $data->text);
        $this->assertEquals(true, $data->is_approved);
    }

    public function testCreateTranslationPhrase()
    {
        $client = $this->getClient();
        $client->jsonRequest('POST', '/api/translations/1/phrases/it', [
            'text' => 'This is the new phrase',
            'approved' => true,
        ]);

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NO_CONTENT
        );

        // Here I'm force to clear the EntityManager to be sure the `Key::getPhrase()`
        // method refresh its relations.
        $this->get('doctrine.orm.entity_manager')->clear();

        // Ensure project has been created
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug('foobar'));
        $translation = $this->get('openl10n.repository.translation')->findOneById($project, 1);
        $phrase = $translation->getPhrase(Locale::parse('it'));

        $this->assertNotNull($phrase, '"it" phrase for translation 1 should be defined');
        $this->assertEquals((string) $phrase->getText(), 'This is the new phrase');
    }

    public function testUpdateTranslationPhrase()
    {
        $client = $this->getClient();
        $client->jsonRequest('PUT', '/api/translations/1/phrases/en', [
            'text' => 'This is the updated phrase',
            'approved' => false,
        ]);

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NO_CONTENT
        );

        // Here I'm force to clear the EntityManager to be sure the `Key::getPhrase()`
        // method refresh its relations.
        $this->get('doctrine.orm.entity_manager')->clear();

        // Ensure project has been created
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug('foobar'));
        $translation = $this->get('openl10n.repository.translation')->findOneById($project, 1);
        $phrase = $translation->getPhrase(Locale::parse('en'));

        $this->assertNotNull($phrase, '"en" phrase for translation 1 should be defined');
        $this->assertEquals((string) $phrase->getText(), 'This is the updated phrase');
    }
}
