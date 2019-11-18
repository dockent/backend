<?php

namespace Dockent\Tests\models;

use Dockent\components\config\Config;
use Dockent\components\FormModel;
use Dockent\models\Settings;
use Phalcon\Di;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionProperty;

/**
 * Class SettingsTest
 * @package Dockent\Tests\models
 */
class SettingsTest extends TestCase
{
    use Rules;
    /**
     * @var Settings
     */
    private $instance;

    public function setUp()
    {
        Di::getDefault()->set(Config::class, function () {
            return new Config('./tests/dummy/config.php');
        });
        $this->instance = new Settings(Di::getDefault()->get(Config::class));
    }

    /**
     * @throws ReflectionException
     */
    public function testConstructor()
    {
        $this->assertInstanceOf(FormModel::class, $this->instance);
        $config = new ReflectionProperty($this->instance, 'config');
        $config->setAccessible(true);
        $this->assertInstanceOf(Config::class, $config->getValue($this->instance));
        $this->assertEquals('127.0.0.1', $this->instance->getBeanstalkHost());
        $this->assertEquals('11300', $this->instance->getBeanstalkPort());
    }

    public function testSetBeanstalkHost()
    {
        $this->instance->setBeanstalkHost('some.queue.host');
        $this->assertEquals('some.queue.host', $this->instance->getBeanstalkHost());
    }

    public function testSetBeanstalkPort()
    {
        $this->instance->setBeanstalkPort(443);
        $this->assertEquals(443, $this->instance->getBeanstalkPort());
    }

    public function testRules()
    {
        $validators = $this->getValidator()->getValidators();
        $this->assertNotEmpty($validators);
        $this->assertEquals('beanstalkHost', $validators[0][0]);
        $this->assertInstanceOf(PresenceOf::class, $validators[0][1]);
        $this->assertEquals('beanstalkPort', $validators[1][0]);
        $this->assertInstanceOf(PresenceOf::class, $validators[1][1]);
        $this->assertEquals('beanstalkPort', $validators[2][0]);
        $this->assertInstanceOf(Numericality::class, $validators[2][1]);
    }

    public function testSave()
    {
        $this->assertTrue($this->instance->save());
        $this->instance->setBeanstalkHost('');
        $this->assertFalse($this->instance->save());
    }
}