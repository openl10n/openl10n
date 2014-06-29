<?php

namespace Openl10n\Bundle\ApiBundle\Tests\Controller;

use Openl10n\Bundle\ApiBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ResourceControllerTest extends WebTestCase
{
    public function testGetResourceList()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/resources?project=foobar');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK
        );

        $this->assertCount(2, $data, 'There should be 2 resources in "foobar" project');
    }

    public function testGetResource()
    {
        $client = $this->getClient();
        $client->jsonRequest('GET', '/api/resources/1');

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_OK,
            'resource'
        );

        $resource = $this->get('openl10n.repository.resource')->findOneById(1);

        $this->assertNotNull($resource, 'Resource #1 should exist. Unless there is a problem with the fixtures.');
        $this->assertEquals((string) $resource->getProject()->getSlug(), $data->project);
        $this->assertEquals((string) $resource->getPathname(), $data->pathname);
    }

    public function testCreateNewResource()
    {
        $client = $this->getClient();
        $client->jsonRequest('POST', '/api/resources', [
            'project' => 'foobar',
            'pathname' => 'new.en.yml',
        ]);

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_CREATED,
            'resource'
        );

        // Ensure resource has been created
        $resource = $this->get('openl10n.repository.resource')->findOneById($data->id);

        $this->assertNotNull($resource, 'New resource should have been created');
        $this->assertEquals((string) $resource->getPathname(), 'new.en.yml');
    }

    public function testCreateExistingResource()
    {
        $this->markTestIncomplete('Current POST request throw a 500 due to a duplicate key');

        $client = $this->getClient();
        $client->jsonRequest('POST', '/api/resources', [
            'project' => 'foobar',
            'pathname' => 'app/Resources/translations/messages.en.yml',
        ]);

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_BAD_REQUEST
        );
    }

    public function testUpdateResource()
    {
        $client = $this->getClient();
        $client->jsonRequest('PUT', '/api/resources/1', [
            'pathname' => 'update.en.yml',
        ]);

        $data = $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NO_CONTENT
        );

        // Ensure resource has been created
        $resource = $this->get('openl10n.repository.resource')->findOneById(1);

        $this->assertNotNull($resource, 'Resource should still exist');
        $this->assertEquals((string) $resource->getPathname(), 'update.en.yml');
    }

    public function testDeleteProject()
    {
        $this->markTestIncomplete('Not implemented yet');

        $client = $this->getClient();
        $client->jsonRequest('DELETE', '/api/resources/1');

        $this->assertJsonResponse(
            $client->getResponse(),
            Response::HTTP_NO_CONTENT
        );

        $this->assertNull(
            $this->get('openl10n.repository.resource')->findOneBySlug(1),
            'Resource should not exist after a DELETE'
        );
    }
}
