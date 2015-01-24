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
            Response::HTTP_OK
        );

        $this->assertCount(2, (array) $data);
        $this->assertObjectHasAttribute('id', $data[0]);
        $this->assertObjectHasAttribute('identifier', $data[0]);
        $this->assertObjectHasAttribute('resource_id', $data[0]);
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
    }
}
