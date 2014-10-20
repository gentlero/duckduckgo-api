<?php

namespace DDG\Tests\API;

class TopicTest extends TestCase
{
    public function testGetTopicSummary()
    {
        $endpoint       = '/';
        $params         = array('q' => 'dummy');
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint, $params)
            ->will($this->returnValue($expectedResult));

        /** @var $topic \DDG\API\Topic */
        $topic  = $this->getClassMock('DDG\API\Topic', $client);
        $actual = $topic->getSummary('dummy');

        $this->assertEquals($expectedResult, $actual);
    }
}
