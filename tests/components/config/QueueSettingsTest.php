<?php

namespace Dockent\Tests\components\config;

use Dockent\components\config\Configurable;
use Dockent\components\config\QueueSettings;
use PHPUnit\Framework\TestCase;

/**
 * Class QueueSettingsTest
 */
class QueueSettingsTest extends TestCase
{
    /**
     * @var QueueSettings
     */
    private $instance;

    /**
     * @var array
     */
    private $config = [
        'host' => 'localhost',
        'port' => 80
    ];

    public function setUp()
    {
        $this->instance = new QueueSettings($this->config);
    }

    public function testConfigurableInstance()
    {
        $this->assertInstanceOf(Configurable::class, $this->instance);
    }

    public function testGetHost()
    {
        $this->assertEquals($this->config['host'], $this->instance->getHost());
        $this->assertInternalType('string', $this->instance->getHost());
    }

    /**
     * @return array
     */
    public function dataProviderSetHost(): array
    {
        return [
            ['queue.host', 'queue.host'],
            ['queue.host<br>', 'queue.host']
        ];
    }

    /**
     * @dataProvider dataProviderSetHost
     * @param string $value
     * @param string $expected
     */
    public function testSetHost(string $value, string $expected)
    {
        $this->instance->setHost($value);
        $this->assertEquals($expected, $this->instance->getHost());
    }

    public function testGetPort()
    {
        $this->assertEquals($this->config['port'], $this->instance->getPort());
        $this->assertInternalType('int', $this->instance->getPort());
    }

    public function testSetPort()
    {
        $this->instance->setPort(81);
        $this->assertEquals(81, $this->instance->getPort());
    }

    public function testPasteToConfig()
    {
        $result = $this->instance->pasteToConfig();
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('queue', $result);
        $this->assertArrayHasKey('host', $result['queue']);
        $this->assertInternalType('string', $result['queue']['host']);
        $this->assertEquals($this->config['host'], $result['queue']['host']);
        $this->assertArrayHasKey('port', $result['queue']);
        $this->assertInternalType('int', $result['queue']['port']);
        $this->assertEquals($this->config['port'], $result['queue']['port']);
    }

    public function testAfterSave()
    {
        $this->assertTrue($this->instance->afterSave());
    }
}