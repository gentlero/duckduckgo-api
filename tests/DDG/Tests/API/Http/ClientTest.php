<?php

namespace DDG\Tests\API\Http;

use DDG\Tests\API\TestCase;
use DDG\API\Http\Client;

class ClientTest extends TestCase
{
    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        $this->client = new Client();
    }

    public function testGetSelfInstance()
    {
        $this->assertInstanceOf('\Buzz\Client\Curl', $this->client->getTransport());
    }

    public function testGetApiBaseUrl()
    {
        $this->assertEquals('https://api.duckduckgo.com', $this->client->getApiBaseUrl());
    }

    public function testShouldDoGetRequestAndReturnResponseInstance()
    {
        $endpoint   = '/';
        $params     = array('format' => 'json');
        $headers    = array('2' => '4');
        $baseClient = $this->getBrowserMock();
        $client     = new Client(array(
                'base_url'      => 'http://example.com'
            ),
            $baseClient
        );
        $response   = $client->get($endpoint, $params, $headers);

        $this->assertInstanceOf('\Buzz\Message\MessageInterface', $response);
        $this->assertInstanceOf('\Buzz\Message\MessageInterface', $client->getLastResponse());
    }

    public function testShouldDoRequestAndReturnResponseInstance()
    {
        $endpoint   = '/';
        $params     = array('q' => 'dummy');
        $headers    = array('1' => '2');
        $baseClient = $this->getBrowserMock();
        $client     = new Client(array(), $baseClient);
        $response   = $client->request($endpoint, $params, 'POST', $headers);

        $this->assertInstanceOf('\Buzz\Message\MessageInterface', $response);
    }
}
