<?php

namespace Dockent\Tests\models;

use Dockent\components\FormModel;
use Dockent\models\CreateContainer;
use Phalcon\Validation\Validator\PresenceOf;
use PHPUnit\Framework\TestCase;

class CreateContainerTest extends TestCase
{
    use Rules;

    /**
     * @var CreateContainer
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new CreateContainer();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(FormModel::class, $this->instance);
    }

    public function testGetImage()
    {
        $this->assertInternalType('string', $this->instance->getImage());
        $this->assertEquals('', $this->instance->getImage());
    }

    public function testGetCmd()
    {
        $this->assertInternalType('string', $this->instance->getCmd());
        $this->assertEquals('', $this->instance->getCmd());
    }

    public function testGetName()
    {
        $this->assertInternalType('string', $this->instance->getName());
        $this->assertEquals('', $this->instance->getName());
    }

    public function testIsStart()
    {
        $this->assertInternalType('bool', $this->instance->isStart());
        $this->assertFalse($this->instance->isStart());
    }

    public function testSetImage()
    {
        $this->instance->setImage('ubuntu:latest');
        $this->assertEquals('ubuntu:latest', $this->instance->getImage());
    }

    public function testSetCmd()
    {
        $this->instance->setCmd('./run.sh');
        $this->assertEquals('./run.sh', $this->instance->getCmd());
    }

    public function testSetName()
    {
        $this->instance->setName('my-container');
        $this->assertEquals('my-container', $this->instance->getName());
    }

    public function testSetStart()
    {
        $this->instance->setStart(true);
        $this->assertTrue($this->instance->isStart());
    }

    public function testRules()
    {
        $validators = $this->getValidator()->getValidators();
        $this->assertNotEmpty($validators);
        $this->assertEquals('Image', $validators[0][0]);
        $this->assertInstanceOf(PresenceOf::class, $validators[0][1]);
    }
}
