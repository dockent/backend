<?php

namespace Dockent\Tests\components;

use Dockent\components\Logger;
use Phalcon\Logger as PhalconLogger;
use Phalcon\Logger\AdapterInterface;
use Phalcon\Logger\Formatter\Json;
use Phalcon\Logger\FormatterInterface;
use function PHPSTORM_META\map;
use PHPUnit\Framework\TestCase;

/**
 * Class LoggerTest
 * @package Dockent\Tests\components
 */
class LoggerTest extends TestCase
{
    /**
     * @var Logger
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new Logger('127.0.0.1', 8080);
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(AdapterInterface::class, $this->instance);
    }

    public function testSetFormatter()
    {
        $this->assertInstanceOf(AdapterInterface::class, $this->instance->setFormatter(new Json()));
        $this->assertInstanceOf(Json::class, $this->instance->getFormatter());
    }

    public function testGetFormatter()
    {
        $this->assertInstanceOf(FormatterInterface::class, $this->instance->getFormatter());
    }

    public function testSetLogLevel()
    {
        $this->assertInstanceOf(AdapterInterface::class, $this->instance->setLogLevel(PhalconLogger::ALERT));
        $this->assertEquals(PhalconLogger::ALERT, $this->instance->getLogLevel());
    }

    public function testGetLogLevel()
    {
        $this->assertEquals(PhalconLogger::ERROR, $this->instance->getLogLevel());
    }

    public function testTransaction()
    {
        /** Begin */
        $this->assertInstanceOf(AdapterInterface::class, $this->instance->begin());
        $transactionStatus = new \ReflectionProperty($this->instance, 'transactionStatus');
        $transactionStatus->setAccessible(true);
        $this->assertTrue($transactionStatus->getValue($this->instance));
        /** Log */
        $transactionStack = new \ReflectionProperty($this->instance, 'transactionStack');
        $transactionStack->setAccessible(true);
        $this->assertInternalType('array', $transactionStack->getValue($this->instance));
        $this->assertEmpty($transactionStack->getValue($this->instance));
        $this->assertInstanceOf(AdapterInterface::class, $this->instance->log(PhalconLogger::CRITICAL,
            'Message',
            ['Context' => 'Array']));
        $this->assertNotEmpty($transactionStack->getValue($this->instance));
        $this->assertEquals([
            'type' => PhalconLogger::CRITICAL,
            'message' => 'Message',
            'context' => ['Context' => 'Array']
        ], $transactionStack->getValue($this->instance)[0]);
        /** Rollback */
        $this->assertInstanceOf(AdapterInterface::class, $this->instance->rollback());
        $this->assertInternalType('array', $transactionStack->getValue($this->instance));
        $this->assertEmpty($transactionStack->getValue($this->instance));
        $this->assertFalse($transactionStatus->getValue($this->instance));
    }

    public function testClose()
    {
        $this->assertTrue($this->instance->close());
    }
}
