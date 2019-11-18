<?php

namespace Dockent\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class MigrationRunnerConfigTest
 * @package Dockent\Tests
 */
class MigrationRunnerConfigTest extends TestCase
{
    public function testConfig()
    {
        $config = require './src/app/migration_runner.config.php';
        $this->assertInternalType('array', $config);
        $this->assertArrayHasKey('adapter', $config);
        $this->assertInternalType('string', $config['adapter']);
        $this->assertArrayHasKey('dbname', $config);
        $this->assertInternalType('string', $config['dbname']);
    }
}