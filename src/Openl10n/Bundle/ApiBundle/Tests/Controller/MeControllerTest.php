<?php

namespace Openl10n\Bundle\ApiBundle\Tests\Controller;

use Openl10n\Bundle\ApiBundle\Test\WebTestCase;
use Openl10n\Value\Localization\Locale;
use Openl10n\Value\String\Slug;
use Symfony\Component\HttpFoundation\Response;

class MeControllerTest extends WebTestCase
{
    public function testGetUMeIndexUserData()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/me');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK
        );

        $this->assertEquals('user', $data->username);
        $this->assertEquals('User', $data->name);
        $this->assertEquals('user@example.org', $data->email);
    }
}
