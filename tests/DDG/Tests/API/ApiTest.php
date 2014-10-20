<?php

namespace DDG\Tests\API;

use DDG\API\Api;

class ApiTest extends TestCase
{
    public function testFormatSwitch()
    {
        $api = new Api();

        // default should be json
        $this->assertEquals('json', $api->getFormat());

        $api->setFormat('xml');
        $this->assertEquals('xml', $api->getFormat());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetInvalidFormat()
    {
        $api = new Api();

        $api->setFormat('invalid');
    }
}
