<?php

namespace DDG\Tests\API;

use Buzz\Message\Response;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function getHttpClientMock()
    {
        $transportClient = $this->getTransportClientMock();

        return $this->getMockBuilder('DDG\API\HTTP\Client')
            ->setMethods(array('get', 'post', 'put', 'delete'))
            ->setConstructorArgs(array(array(), $transportClient))
            ->getMock();
    }

    protected function getTransportClientMock()
    {
        $client = $this->getBrowserMock();

        $client->expects($this->any())->method('setTimeout')->with(10);
        $client->expects($this->any())->method('setVerifyPeer')->with(true);
        $client->expects($this->any())->method('send');

        return $client;
    }

    protected function getBrowserMock()
    {
        return $this->getMock('Buzz\Client\ClientInterface', array('setTimeout', 'setVerifyPeer', 'send', 'setMaxRedirects'));
    }

    protected function fakeResponse($data)
    {
        $response = new Response();

        $response->addHeader('Content-Type: application/x-javascript');
        $response->setContent(json_encode($data));

        return $response;
    }

    protected function getClassMock($class, $httpClient)
    {
        $obj = new $class($this->getTransportClientMock());
        $obj->setClient($httpClient);

        return $obj;
    }
}
