<?php

namespace Dockent\Tests\models;

use Dockent\components\FormModel;
use Dockent\models\DockerfileBuilder;
use Phalcon\Validation\Validator\PresenceOf;
use PHPUnit\Framework\TestCase;

/**
 * Class DockerfileBuilderTest
 * @package Dockent\Tests\models
 */
class DockerfileBuilderTest extends TestCase
{
    use Rules;

    /**
     * @var DockerfileBuilder
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new DockerfileBuilder();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(FormModel::class, $this->instance);
    }

    public function testGetFrom()
    {
        $this->assertInternalType('string', $this->instance->getFrom());
        $this->assertEquals('', $this->instance->getFrom());
    }

    public function testSetFrom()
    {
        $this->instance->setFrom('ubuntu:latest');
        $this->assertEquals('ubuntu:latest', $this->instance->getFrom());
    }

    public function testGetRun()
    {
        $this->assertInternalType('string', $this->instance->getRun());
        $this->assertEquals('', $this->instance->getRun());
    }

    public function testSetRun()
    {
        $this->instance->setRun('bash');
        $this->assertEquals('bash', $this->instance->getRun());
    }

    public function testGetCmd()
    {
        $this->assertInternalType('string', $this->instance->getCmd());
        $this->assertEquals('', $this->instance->getCmd());
    }

    public function testSetCmd()
    {
        $this->instance->setCmd('run.sh');
        $this->assertEquals('run.sh', $this->instance->getCmd());
    }

    public function testGetExpose()
    {
        $this->assertInternalType('string', $this->instance->getExpose());
        $this->assertEquals('', $this->instance->getExpose());
    }

    public function testSetExpose()
    {
        $this->instance->setExpose('80 443');
        $this->assertEquals('80 443', $this->instance->getExpose());
    }

    public function testGetEnv()
    {
        $this->assertInternalType('string', $this->instance->getEnv());
        $this->assertEquals('', $this->instance->getEnv());
    }

    public function testSetEnv()
    {
        $this->instance->setEnv('ENV PROD');
        $this->assertEquals('ENV PROD', $this->instance->getEnv());
    }

    public function testGetAdd()
    {
        $this->assertInternalType('string', $this->instance->getAdd());
        $this->assertEquals('', $this->instance->getAdd());
    }

    public function testSetAdd()
    {
        $this->instance->setAdd('./run.sh /var/');
        $this->assertEquals('./run.sh /var/', $this->instance->getAdd());
    }

    public function testGetCopy()
    {
        $this->assertInternalType('string', $this->instance->getCopy());
        $this->assertEquals('', $this->instance->getCopy());
    }

    public function testSetCopy()
    {
        $this->instance->setCopy('/html /var/www');
        $this->assertEquals('/html /var/www', $this->instance->getCopy());
    }

    public function testGetVolume()
    {
        $this->assertInternalType('string', $this->instance->getVolume());
        $this->assertEquals('', $this->instance->getVolume());
    }

    public function testSetVolume()
    {
        $this->instance->setVolume('/var/');
        $this->assertEquals('/var/', $this->instance->getVolume());
    }

    public function testGetWorkdir()
    {
        $this->assertInternalType('string', $this->instance->getWorkdir());
        $this->assertEquals('', $this->instance->getWorkdir());
    }

    public function testSetWorkdir()
    {
        $this->instance->setWorkdir('/var/www');
        $this->assertEquals('/var/www', $this->instance->getWorkdir());
    }

    public function testRules()
    {
        $validators = $this->getValidator()->getValidators();
        $this->assertNotEmpty($validators);
        $this->assertEquals('from', $validators[0][0]);
        $this->assertInstanceOf(PresenceOf::class, $validators[0][1]);
    }
}