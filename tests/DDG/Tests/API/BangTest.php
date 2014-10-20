<?php

namespace DDG\Tests\API;

class BangTest extends TestCase
{
    public function testGetBang()
    {
        $endpoint       = '/';
        $params         = array('q' => '!dummy');
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint, $params)
            ->will($this->returnValue($expectedResult));

        /** @var $topic \DDG\API\Bang */
        $topic  = $this->getClassMock('DDG\API\Bang', $client);
        $actual = $topic->get('dummy');

        $this->assertEquals($expectedResult, $actual);
    }

    public function testGetBangWithExclamationSign()
    {
        $endpoint       = '/';
        $params         = array('q' => '!dummy');
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint, $params)
            ->will($this->returnValue($expectedResult));

        /** @var $topic \DDG\API\Bang */
        $topic  = $this->getClassMock('DDG\API\Bang', $client);
        $actual = $topic->get('!dummy');

        $this->assertEquals($expectedResult, $actual);
    }
}
