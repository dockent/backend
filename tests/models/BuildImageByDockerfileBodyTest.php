<?php

namespace Dockent\Tests\models;

use Dockent\components\FormModel;
use Dockent\models\BuildImageByDockerfileBody;
use Phalcon\Validation\Validator\PresenceOf;
use PHPUnit\Framework\TestCase;

class BuildImageByDockerfileBodyTest extends TestCase
{
    use Rules;

    /**
     * @var BuildImageByDockerfileBody
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new BuildImageByDockerfileBody();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(FormModel::class, $this->instance);
    }

    public function testGetDockerfileBody()
    {
        $this->assertInternalType('string', $this->instance->getDockerfileBody());
        $this->assertEquals('', $this->instance->getDockerfileBody());
    }

    public function testSetDockerfileBody()
    {
        $this->instance->setDockerfileBody('FROM busybox');
        $this->assertEquals('FROM busybox', $this->instance->getDockerfileBody());
    }

    public function testRules()
    {
        $validators = $this->getValidator()->getValidators();
        $this->assertNotEmpty($validators);
        $this->assertEquals('dockerfileBody', $validators[0][0]);
        $this->assertInstanceOf(PresenceOf::class, $validators[0][1]);
    }
}
