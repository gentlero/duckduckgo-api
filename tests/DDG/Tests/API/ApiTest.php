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

    public function testApplicationName()
    {
        $api = new Api();

        $api->setAppName('super');

        $this->assertEquals('super', $api->getAppName());
    }

    public function testSingleEntryPoint()
    {
        /** @var \DDG\API\Topic $topic */
        $ddg        = new Api();
        $listener   = $this->getMock('DDG\API\Http\Listener\ListenerInterface');

        $listener->expects($this->any())->method('getName')->will($this->returnValue('dummy'));

        // listener should be forwarded to any child
        $ddg->getClient()->addListener($listener);

        $topic = $ddg->api('Topic');

        $this->assertInstanceOf('\DDG\API\Topic', $topic);
        $this->assertTrue($ddg->getClient()->isListener('dummy'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSingleEntryPointWithEmptyChild()
    {
        $ddg = new Api();

        $ddg->api('');
    }

    /**
     * @expectedException \Exception
     */
    public function testSingleEntryPointWithInvalidChild()
    {
        $ddg = new Api();

        $ddg->api('inexistent');
    }
}
