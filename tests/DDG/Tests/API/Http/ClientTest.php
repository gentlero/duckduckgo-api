<?php

namespace DDG\Tests\API\Http;

use Buzz\Message\Request;
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
        $this->assertEquals('q=dummy&t=my+app', $client->getLastRequest()->getContent());
    }

    public function testAddListener()
    {
        $listener = $this->getListenerMock();

        $this->client->addListener($listener, 1);
        $this->client->addListener($listener, 14);

        $this->assertInstanceOf('DDG\API\Http\Listener\ListenerInterface', $this->client->getListener('dummy'));
    }

    public function testDeleteListener()
    {
        $listener = $this->getListenerMock('lorem');

        $this->client->addListener($listener);
        $this->assertTrue($this->client->isListener('lorem'));

        $this->client->delListener($listener);

        $this->assertFalse($this->client->isListener('lorem'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetAbsentListener()
    {
        $this->client->getListener('invalid');
    }

    public function testSetCustomRequest()
    {
        $endpoint   = '/';
        $params     = array('q' => 'dummy');
        $headers    = array('X-Test: yes');
        $client     = new Client(
            array(),
            $this->getMock('\Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send'))
        );

        $request = new Request('GET', $endpoint);
        $request->addHeaders($headers);
        $client->setRequest($request);

        $response = $client->get($endpoint, $params);
        $request = $client->getLastRequest();

        $this->assertEquals('yes', $request->getHeader('X-Test'));
        $this->assertInstanceOf('\Buzz\Message\Response', $response);
    }

    private function getListenerMock($name = 'dummy')
    {
        $listener = $this->getMock('DDG\API\Http\Listener\ListenerInterface');

        $listener->expects($this->any())->method('getName')->will($this->returnValue($name));

        return $listener;
    }
}
