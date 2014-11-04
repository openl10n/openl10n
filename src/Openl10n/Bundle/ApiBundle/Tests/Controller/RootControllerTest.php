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
        $this->assertStringStartsWith($message, $data->motd);
    }

    public function provideRootMessage()
    {
        return [
            // Main language
            ["en", "Welcome"],
            ["fr", "Bienvenue"],
            // Language with region
            ["fr-FR", "Bienvenue"],
            // Priorities
            ["en;q=0.8,fr;q=0.4", "Welcome"],
            ["en;q=0.4,fr;q=0.8", "Bienvenue"],
        ];
    }
}
