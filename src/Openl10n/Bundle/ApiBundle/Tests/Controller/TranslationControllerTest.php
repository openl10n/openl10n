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
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/translations?project=foobar');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK
        );

        $this->assertCount(2, (array) $data);
        $this->assertObjectHasAttribute('id', $data[0]);
        $this->assertObjectHasAttribute('identifier', $data[0]);
        $this->assertObjectHasAttribute('resource_id', $data[0]);
        $this->assertObjectHasAttribute('phrases', $data[0]);
        $this->assertObjectHasAttribute('en', $data[0]->phrases);
        $this->assertObjectHasAttribute('fr', $data[0]->phrases);
        $this->assertObjectHasAttribute('locale', $data[0]->phrases->en);
        $this->assertObjectHasAttribute('text', $data[0]->phrases->en);
        $this->assertObjectHasAttribute('is_approved', $data[0]->phrases->en);
        $this->assertObjectHasAttribute('created_at', $data[0]->phrases->en);
        $this->assertObjectHasAttribute('updated_at', $data[0]->phrases->en);
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
        $project = $this->get('openl10n.repository.project')->findOneBySlug(new Slug('foobar'));
        $resources = $this->get('openl10n.repository.resource')->findByProject($project);
        $resource = $resources[0];

        $client = $this->getClient();
        $client->jsonRequest('POST', '/api/translations', [
            'resource' => $resource->getId(),
            'identifier' => 'new.translation.key',
        ]);

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_CREATED
        );

        $this->assertObjectHasAttribute('id', $data);

        // Ensure translation has been created
        $translation = $this->get('openl10n.repository.translation')->findOneById($data->id);

        $this->assertNotNull($translation, 'New translation should exist');
        $this->assertEquals($translation->getResource()->getId(), $resource->getId());
        $this->assertEquals((string) $translation->getIdentifier(), 'new.translation.key');
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
            Response::HTTP_OK
        );

        $this->assertCount(2, (array) $data);
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

    public function testDeleteTranslationPhrase()
    {
        $client = $this->getClient();
        $client->jsonRequest('DELETE', '/api/translations/1/phrases/fr');

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NO_CONTENT
        );

        // Here I'm force to clear the EntityManager to be sure the `Key::getPhrase()`
        // method refresh its relations.
        $this->get('doctrine.orm.entity_manager')->clear();

        $translation = $this->get('openl10n.repository.translation')->findOneById(1);

        $this->assertNull(
            $translation->getPhrase(Locale::parse('fr')),
            'French phrase of translation 1 should not exist anymore'
        );
    }
}
