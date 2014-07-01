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

    public function testDeleteResource()
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

    public function testImportResource()
    {
        $this->markTestIncomplete('');
    }

    /**
     * @dataProvider dataProviderExportFormat
     */
    public function testExportResource($format)
    {
        $url = '/api/resources/1/export?locale=en';
        if (null !== $format) {
            $url .= '&format='.$format;
        }

        $client = $this->getClient();
        $client->request('GET', $url);

        $response = $client->getResponse();
        $content = trim(file_get_contents($response->getFile()->getPathname()));

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($this->getExportContent($format), $content);
    }

    public function dataProviderExportFormat()
    {
        return [
            [null],
            ['yml'],
            ['ini'],
            ['csv'],
            ['json'],
            ['xlf'],
        ];
    }

    /**
     * Get export content of resource 1 in different format
     *
     * @param string $format The format of the export
     *
     * @return string The content as text
     */
    private function getExportContent($format)
    {
        switch ($format) {
            case 'ini':
                return <<<EOF
example.key1="This is a first example"
example.key2="This is a second example"
EOF;

            case 'csv':
                return <<<EOF
example.key1;"This is a first example"
example.key2;"This is a second example"
EOF;

            case 'json':
                return <<<EOF
{
    "example.key1": "This is a first example",
    "example.key2": "This is a second example"
}
EOF;

            case 'xlf':
                return <<<EOF
<?xml version="1.0" encoding="utf-8"?>
<xliff xmlns="urn:oasis:names:tc:xliff:document:1.2" version="1.2">
  <file source-language="en" datatype="plaintext" original="file.ext">
    <body>
      <trans-unit id="03fdeaf5007f7e942ebcf2d1a5803b84" resname="example.key1">
        <source>example.key1</source>
        <target>This is a first example</target>
      </trans-unit>
      <trans-unit id="a4cfdcd4f5cd9e1d18fc4aef6fcac406" resname="example.key2">
        <source>example.key2</source>
        <target>This is a second example</target>
      </trans-unit>
    </body>
  </file>
</xliff>
EOF;

            // default format is Yaml
            case 'yml':
            default:
                return <<<EOF
example.key1: 'This is a first example'
example.key2: 'This is a second example'
EOF;
        }
    }
}
