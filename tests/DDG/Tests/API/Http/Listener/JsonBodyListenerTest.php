<?php

namespace DDG\Tests\API\Http\Listener;

use DDG\API\Http\Client;
use DDG\API\Http\Listener\JsonBodyListener;
use DDG\API\Topic;
use DDG\Tests\API\TestCase;

/**
 * @author Alexandru Guzinschi <alex@gentle.ro>
 */
class JsonBodyListenerTest extends TestCase
{
    public function testDecodeJsonBody()
    {
        $topic  = new Topic();
        $client = new Client(
            array(),
            $this->getMock('\Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send'))
        );
        $client->setResponse($this->fakeResponse(array('key' => 'value')));

        $topic->setClient($client);
        $topic->getClient()->addListener(new JsonBodyListener());

        $response = $topic->getSummary('dummy');

        $this->assertTrue($topic->getClient()->hasListeners());
        $this->assertInstanceOf('\DDG\Api\Http\Listener\ListenerInterface', $topic->getClient()->getListener('json_body'));
        $this->assertInstanceOf('\Buzz\Message\Response', $response);
        $this->assertInstanceOf('\stdClass', $response->getContent());
    }
}
