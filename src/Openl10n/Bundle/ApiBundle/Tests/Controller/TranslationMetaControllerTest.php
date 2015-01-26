<?php

namespace Openl10n\Bundle\ApiBundle\Tests\Controller;

use Openl10n\Bundle\ApiBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TranslationMetaControllerTest extends WebTestCase
{
    public function testGetTranslationMeta()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/translations/1/meta');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK,
            'translation_meta'
        );

        $this->assertEquals('This is the description of example.key1', $data->description);
    }

    public function testUpdateTranslationMeta()
    {
        $client = $this->getClient();
        $client->jsonRequest('PUT', '/api/translations/1/meta', [
            'description' => 'This is an update test',
        ]);

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NO_CONTENT
        );

        // Ensure meta has been updated
        $translation = $this->get('openl10n.repository.translation')->findOneById(1);
        $meta = $translation->getMeta();

        $this->assertEquals('This is an update test', (string) $meta->getDescription());
    }
}
