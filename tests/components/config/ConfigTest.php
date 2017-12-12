<?php

namespace Dockent\Tests\components\config;

use Dockent\components\config\Config;
use Dockent\components\config\Configurable;
use Phalcon\Config as PhalconConfig;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigTest
 * @package Dockent\Tests\components\config
 */
class ConfigTest extends TestCase
{
    const PATH = './tests/dummy/config.php';
    /**
     * @var Config
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new Config(self::PATH);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(PhalconConfig::class, $this->instance);
        $configPath = new \ReflectionProperty($this->instance, 'configPath');
        $configPath->setAccessible(true);
        $this->assertInternalType('string', $configPath->getValue($this->instance));
        $this->assertEquals(self::PATH, $configPath->getValue($this->instance));
    }

    public function testAdd()
    {
        $this->addValuesToConfig();
        $storage = new \ReflectionProperty($this->instance, 'storage');
        $storage->setAccessible(true);
        $this->assertInternalType('array', $storage->getValue($this->instance));
        $this->assertCount(1, $storage->getValue($this->instance));
        $this->assertInstanceOf(Configurable::class, $storage->getValue($this->instance)[0]);
    }

    private function addValuesToConfig()
    {
        $this->instance->add(new class implements Configurable {

            /**
             * @return array
             */
            public function pasteToConfig(): array
            {
                return [
                    'block1' => [
                        'key1' => 'value1',
                        'key2' => 'value2'
                    ]
                ];
            }

            /**
             * @return bool
             */
            public function afterSave(): bool
            {
                return true;
            }
        });
    }

    public function testSave()
    {
        $this->addValuesToConfig();
        $this->assertInternalType('bool', $this->instance->save());
        $storage = new \ReflectionProperty($this->instance, 'storage');
        $storage->setAccessible(true);
        $this->assertInternalType('array', $storage->getValue($this->instance));
        $this->assertEmpty($storage->getValue($this->instance));
        $this->setUp();
        $this->assertEquals('value1', $this->instance->path('block1.key1'));
        $this->assertEquals('value2', $this->instance->path('block1.key2'));
    }
}