<?php

namespace Dockent\Tests\components;

use Dockent\components\FormModel as FormModelBase;
use Dockent\Tests\mocks\FormModel;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use PHPUnit\Framework\TestCase;

/**
 * Class FormModelTest
 * @package Dockent\Tests\components
 */
class FormModelTest extends TestCase
{
    /**
     * @var FormModel
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new FormModel();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(Validation::class, $this->instance->getValidator());
        $this->assertInstanceOf(FormModelBase::class, $this->instance);
    }

    public function testAssign()
    {
        $parameters = [
            'stringWithSetter' => 'String with setter content',
            'boolWithSetter' => true,
            'stringWithoutSetter' => 'String without setter content',
            'boolWithoutSetter' => true
        ];
        $this->instance->assign($parameters);
        $this->assertEquals($parameters['stringWithSetter'], $this->instance->getStringWithSetter());
        $this->assertEquals($parameters['boolWithSetter'], $this->instance->isBoolWithSetter());
        $this->assertEquals($parameters['stringWithoutSetter'], $this->instance->getStringWithoutSetter());
        $this->assertEquals($parameters['boolWithoutSetter'], $this->instance->isBoolWithoutSetter());
    }

    public function testEmptyValidate()
    {
        $this->assertTrue($this->instance->validate());
    }

    public function testValidate()
    {
        $this->instance->getValidator()->add(['stringWithSetter'], new PresenceOf());
        $this->assertFalse($this->instance->validate());
        $this->instance->setStringWithSetter('Some string');
        $this->assertTrue($this->instance->validate());
    }

    public function testGetErrors()
    {
        $this->assertInternalType('array', $this->instance->getErrors());
        $this->assertEmpty($this->instance->getErrors());
        $this->instance->getValidator()->add(['stringWithSetter'], new PresenceOf());
        $this->instance->validate();
        $this->assertInternalType('array', $this->instance->getErrors());
        $this->assertNotEmpty($this->instance->getErrors());
        $this->assertArrayHasKey('stringWithSetter', $this->instance->getErrors());
        $this->assertNotEmpty($this->instance->getErrors()['stringWithSetter']);
        $this->instance->setStringWithSetter('Some string');
        $this->instance->validate();
        $this->assertInternalType('array', $this->instance->getErrors());
        $this->assertEmpty($this->instance->getErrors());
    }

    public function testGetError()
    {
        $this->assertInternalType('array', $this->instance->getError('stringWithSetter'));
        $this->assertEmpty($this->instance->getError('stringWithSetter'));
        $this->instance->getValidator()->add(['stringWithSetter'], new PresenceOf());
        $this->instance->validate();
        $this->assertNotEmpty($this->instance->getError('stringWithSetter'));
        $this->instance->setStringWithSetter('Some string');
        $this->instance->validate();
        $this->assertEmpty($this->instance->getError('stringWithSetter'));
    }
}
