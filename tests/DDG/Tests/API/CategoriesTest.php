<?php

namespace DDG\Tests\API;

class CategoriesTest extends TestCase
{
    public function testGetCategories()
    {
        $endpoint       = '/';
        $params         = array('q' => 'dummy');
        $expectedResult = json_encode('dummy');

        $client = $this->getHttpClientMock();
        $client->expects($this->once())
            ->method('get')
            ->with($endpoint, $params)
            ->will($this->returnValue($expectedResult));

        /** @var $topic \DDG\API\Categories */
        $topic  = $this->getClassMock('DDG\API\Categories', $client);
        $actual = $topic->get('dummy');

        $this->assertEquals($expectedResult, $actual);
    }
}
