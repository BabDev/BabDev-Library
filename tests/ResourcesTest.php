<?php declare(strict_types=1);

namespace BabDev\Transifex\Tests;

use BabDev\Transifex\Resources;

/**
 * Test class for \BabDev\Transifex\Resources.
 */
class ResourcesTest extends TransifexTestCase
{
    /**
     * @testdox createResource() with inline content provided in the options returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::createResource
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testCreateResourceContent(): void
    {
        $this->prepareSuccessTest(201);

        // Additional options
        $options = [
            'accept_translations' => true,
            'category'            => 'whatever',
            'priority'            => 3,
            'content'             => 'Test="Test"',
        ];

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createResource(
            'babdev-transifex',
            'BabDev Transifex Data',
            'babdev-transifex',
            'INI',
            $options
        );

        $this->validateSuccessTest('/api/2/project/babdev-transifex/resources/', 'POST', 201);
    }

    /**
     * @testdox createResource() with an attached file in the options returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::createResource
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testCreateResourceFile(): void
    {
        $this->prepareSuccessTest(201);

        // Additional options
        $options = [
            'accept_translations' => true,
            'category'            => 'whatever',
            'priority'            => 3,
            'file'                => __DIR__ . '/stubs/source.ini',
        ];

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createResource(
            'babdev-transifex',
            'BabDev Transifex Data',
            'babdev-transifex',
            'INI',
            $options
        );

        $this->validateSuccessTest('/api/2/project/babdev-transifex/resources/', 'POST', 201);
    }

    /**
     * @testdox createResource() with an attached file in the options that does not exist throws an InvalidArgumentException
     *
     * @covers  \BabDev\Transifex\Resources::createResource
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     *
     * @expectedException \InvalidArgumentException
     */
    public function testCreateResourceFileDoesNotExist(): void
    {
        // Additional options
        $options = [
            'accept_translations' => true,
            'category'            => 'whatever',
            'priority'            => 3,
            'file'                => __DIR__ . '/stubs/does-not-exist.ini',
        ];

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createResource(
            'babdev-transifex',
            'BabDev Transifex Data',
            'babdev-transifex',
            'INI',
            $options
        );
    }

    /**
     * @testdox createResource() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::createResource
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testCreateResourceFailure(): void
    {
        $this->prepareFailureTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->createResource(
            'babdev-transifex',
            'BabDev Transifex Data',
            'babdev-transifex',
            'INI',
            ['content' => 'Test="Test"']
        );

        $this->validateFailureTest('/api/2/project/babdev-transifex/resources/', 'POST');
    }

    /**
     * @testdox deleteResource() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::deleteResource
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testDeleteResource(): void
    {
        $this->prepareSuccessTest(204);

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->deleteResource('babdev', 'babdev-transifex');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex', 'DELETE', 204);
    }

    /**
     * @testdox deleteResource() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::deleteResource
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testDeleteResourceFailure(): void
    {
        $this->prepareFailureTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->deleteResource('babdev', 'babdev-transifex');

        $this->validateFailureTest('/api/2/project/babdev/resource/babdev-transifex', 'DELETE');
    }

    /**
     * @testdox getResource() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResource
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetResource(): void
    {
        $this->prepareSuccessTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getResource('babdev', 'babdev-transifex', true);

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/');

        $this->assertSame(
            'details',
            $this->client->getRequest()->getUri()->getQuery(),
            'The API request did not include the expected query string.'
        );
    }

    /**
     * @testdox getResource() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResource
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetResourceFailure(): void
    {
        $this->prepareFailureTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getResource('babdev', 'babdev-transifex', true);

        $this->validateFailureTest('/api/2/project/babdev/resource/babdev-transifex/');
    }

    /**
     * @testdox getResourceContent() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResourceContent
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetResourceContent(): void
    {
        $this->prepareSuccessTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getResourceContent('babdev', 'babdev-transifex');

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/content/');
    }

    /**
     * @testdox getResourceContent() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResourceContent
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetResourceContentFailure(): void
    {
        $this->prepareFailureTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getResourceContent('babdev', 'babdev-transifex');

        $this->validateFailureTest('/api/2/project/babdev/resource/babdev-transifex/content/');
    }

    /**
     * @testdox getResources() returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResources
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetResources(): void
    {
        $this->prepareSuccessTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getResources('babdev');

        $this->validateSuccessTest('/api/2/project/babdev/resources');
    }

    /**
     * @testdox getResources() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::getResources
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testGetResourcesFailure(): void
    {
        $this->prepareFailureTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->getResources('babdev');

        $this->validateFailureTest('/api/2/project/babdev/resources');
    }

    /**
     * @testdox updateResourceContent() with an attached file returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testUpdateResourceContentFile(): void
    {
        $this->prepareSuccessTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateResourceContent(
            'babdev',
            'babdev-transifex',
            __DIR__ . '/stubs/source.ini',
            'file'
        );

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/content/', 'PUT');
    }

    /**
     * @testdox updateResourceContent() with inline content returns a Response object indicating a successful API connection
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testUpdateResourceContentString(): void
    {
        $this->prepareSuccessTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateResourceContent(
            'babdev',
            'babdev-transifex',
            'TEST="Test"'
        );

        $this->validateSuccessTest('/api/2/project/babdev/resource/babdev-transifex/content/', 'PUT');
    }

    /**
     * @testdox updateResourceContent() returns a Response object indicating a failed API connection
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     */
    public function testUpdateResourceContentFailure(): void
    {
        $this->prepareFailureTest();

        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateResourceContent('babdev', 'babdev-transifex', 'TEST="Test"');

        $this->validateFailureTest('/api/2/project/babdev/resource/babdev-transifex/content/', 'PUT');
    }

    /**
     * @testdox updateResourceContent() throws an InvalidArgumentException when an invalid content type is specified
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateResourceContentBadType(): void
    {
        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateResourceContent(
            'babdev',
            'babdev-transifex',
            'TEST="Test"',
            'stuff'
        );
    }

    /**
     * @testdox updateResourceContent() throws an InvalidArgumentException when a non-existing file is specified
     *
     * @covers  \BabDev\Transifex\Resources::updateResourceContent
     * @covers  \BabDev\Transifex\ApiConnector
     *
     * @uses    \BabDev\Transifex\ApiConnector
     *
     * @expectedException \InvalidArgumentException
     */
    public function testUpdateResourceContentUnexistingFile(): void
    {
        (new Resources($this->client, $this->requestFactory, $this->streamFactory, $this->uriFactory, $this->options))->updateResourceContent(
            'babdev',
            'babdev-transifex',
            __DIR__ . '/stubs/does-not-exist.ini',
            'file'
        );
    }
}
