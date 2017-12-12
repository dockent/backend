<?php

namespace Dockent\Tests\models;

use Dockent\components\FormModel;
use Dockent\models\BuildImageByDockerfilePath;
use Phalcon\Validation\Validator\Callback;
use Phalcon\Validation\Validator\PresenceOf;
use PHPUnit\Framework\TestCase;

class BuildImageByDockerfilePathTest extends TestCase
{
    use Rules;

    /**
     * @var BuildImageByDockerfilePath
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new BuildImageByDockerfilePath();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(FormModel::class, $this->instance);
    }

    public function testGetDockerfilePath()
    {
        $this->assertInternalType('string', $this->instance->getDockerfilePath());
        $this->assertEquals('', $this->instance->getDockerfilePath());
    }

    public function testSetDockerfilePath()
    {
        $this->instance->setDockerfilePath('/tmp/docker');
        $this->assertEquals('/tmp/docker', $this->instance->getDockerfilePath());
    }

    public function testRules()
    {
        $validators = $this->getValidator()->getValidators();
        $this->assertNotEmpty($validators);
        $this->assertEquals('dockerfilePath', $validators[0][0]);
        $this->assertInstanceOf(PresenceOf::class, $validators[0][1]);
        $this->assertEquals('dockerfilePath', $validators[1][0]);
        $this->assertInstanceOf(Callback::class, $validators[1][1]);
    }
}
