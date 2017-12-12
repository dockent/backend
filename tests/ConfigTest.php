<?php

namespace Dockent\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class ConfigTest
 * @package Dockent\Tests
 */
class ConfigTest extends TestCase
{
    public function testConfig()
    {
        $config = require './src/app/config.php';
        $this->assertInternalType('array', $config);
        $this->assertArrayHasKey('currentConnection', $config);
        $this->assertInternalType('array', $config['currentConnection']);
        $this->assertArrayHasKey('remote_socket', $config['currentConnection']);
        $this->assertArrayHasKey('queue', $config);
        $this->assertInternalType('array', $config['queue']);
        $this->assertArrayHasKey('host', $config['queue']);
        $this->assertArrayHasKey('port', $config['queue']);
        $this->assertArrayHasKey('logstash', $config);
        $this->assertInternalType('array', $config['logstash']);
        $this->assertArrayHasKey('host', $config['logstash']);
        $this->assertArrayHasKey('port', $config['logstash']);
    }
}