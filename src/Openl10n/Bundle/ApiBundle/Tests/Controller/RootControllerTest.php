<?php

namespace Openl10n\Bundle\ApiBundle\Tests\Controller;

use Openl10n\Bundle\ApiBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RootControllerTest extends WebTestCase
{
    /**
     * @dataProvider provideRootMessage
     */
    public function testGetRoot($locale, $message)
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/', [], ['HTTP_ACCEPT_LANGUAGE' => $locale]);

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK
        );

        $this->assertNotNull($data);
        $this->assertEquals($message, $data->motd);
    }

    public function provideRootMessage()
    {
        return [
            ["en", "Welcome on the OpenLocalization API"],
            ["fr", "Bienvenue sur l'API d'OpenLocalization"],
            ["fr-FR", "Bienvenue sur l'API d'OpenLocalization"],
        ];
    }
}
