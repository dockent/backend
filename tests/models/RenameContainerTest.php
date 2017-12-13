<?php

namespace Dockent\Tests\models;

use Dockent\components\FormModel;
use Dockent\models\RenameContainer;
use Phalcon\Validation\Validator\PresenceOf;
use PHPUnit\Framework\TestCase;

/**
 * Class RenameContainerTest
 * @package Dockent\Tests\models
 */
class RenameContainerTest extends TestCase
{
    use Rules;

    /**
     * @var RenameContainer
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new RenameContainer();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(FormModel::class, $this->instance);
    }

    public function testGetName()
    {
        $this->assertInternalType('string', $this->instance->getName());
        $this->assertEquals('', $this->instance->getName());
    }

    public function testSetName()
    {
        $this->instance->setName('new-name');
        $this->assertEquals('new-name', $this->instance->getName());
    }

    public function testGetId()
    {
        $this->instance->setId('SomeIdValue');
        $this->assertInternalType('string', $this->instance->getId());
        $this->assertEquals('SomeIdValue', $this->instance->getId());
    }

    public function testRules()
    {
        $validators = $this->getValidator()->getValidators();
        $this->assertNotEmpty($validators);
        $this->assertEquals('name', $validators[0][0]);
        $this->assertInstanceOf(PresenceOf::class, $validators[0][1]);
    }

    public function testMap()
    {
        $data = ['Id' => 'SomeIdValue', 'Name' => 'MyName'];
        $this->instance->map(json_decode(json_encode($data)));
        $this->assertEquals('SomeIdValue', $this->instance->getId());
        $this->assertEquals('MyName', $this->instance->getName());
    }
}