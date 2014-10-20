<?php

namespace DDG\Tests\API;

class DisambiguationTest extends TestCase
{
    public function testGetDisambiguation()
    {
        $endpoint       = '/';
        $params         = array('q' => 'dummy');
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint, $params)
            ->will($this->returnValue($expectedResult));

        /** @var $topic \DDG\API\Disambiguation */
        $topic  = $this->getClassMock('DDG\API\Disambiguation', $client);
        $actual = $topic->get('dummy');

        $this->assertEquals($expectedResult, $actual);
    }
}
