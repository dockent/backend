<?php

namespace Dockent\Tests\models;

use Dockent\components\FormModel;
use Dockent\models\CreateNetwork;
use Phalcon\Validation\Validator\PresenceOf;
use PHPUnit\Framework\TestCase;

class CreateNetworkTest extends TestCase
{
    use Rules;

    /**
     * @var CreateNetwork
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new CreateNetwork();
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
        $this->instance->setName('my-network');
        $this->assertEquals('my-network', $this->instance->getName());
    }

    public function testGetDriver()
    {
        $this->assertInternalType('string', $this->instance->getDriver());
        $this->assertEquals('', $this->instance->getDriver());
    }

    public function testSetDriver()
    {
        $this->instance->setDriver('bridge');
        $this->assertEquals('bridge', $this->instance->getDriver());
    }

    public function testIsCheckDuplicate()
    {
        $this->assertInternalType('bool', $this->instance->isCheckDuplicate());
        $this->assertFalse($this->instance->isCheckDuplicate());
    }

    public function testSetCheckDuplicate()
    {
        $this->instance->setCheckDuplicate(true);
        $this->assertTrue($this->instance->isCheckDuplicate());
    }

    public function testIsInternal()
    {
        $this->assertInternalType('bool', $this->instance->isInternal());
        $this->assertFalse($this->instance->isInternal());
    }

    public function testSetInternal()
    {
        $this->instance->setInternal(true);
        $this->assertTrue($this->instance->isInternal());
    }

    public function testIsAttachable()
    {
        $this->assertInternalType('bool', $this->instance->isAttachable());
        $this->assertFalse($this->instance->isAttachable());
    }

    public function testSetAttachable()
    {
        $this->instance->setAttachable(true);
        $this->assertTrue($this->instance->isAttachable());
    }

    public function testIsIngress()
    {
        $this->assertInternalType('bool', $this->instance->isIngress());
        $this->assertFalse($this->instance->isIngress());
    }

    public function testSetIngress()
    {
        $this->instance->setIngress(true);
        $this->assertTrue($this->instance->isIngress());
    }

    public function testIsEnableIPv6()
    {
        $this->assertInternalType('bool', $this->instance->isEnableIPv6());
        $this->assertFalse($this->instance->isEnableIPv6());
    }

    public function testSetEnableIPv6()
    {
        $this->instance->setEnableIPv6(true);
        $this->assertTrue($this->instance->isEnableIPv6());
    }

    public function testGetAttributesAsArray()
    {
        $result = $this->instance->getAttributesAsArray();
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('Name', $result);
        $this->assertArrayHasKey('Driver', $result);
        $this->assertArrayHasKey('CheckDuplicate', $result);
        $this->assertArrayHasKey('Internal', $result);
        $this->assertArrayHasKey('Attachable', $result);
        $this->assertArrayHasKey('Ingress', $result);
        $this->assertArrayHasKey('EnableIPv6', $result);
    }

    public function testRules()
    {
        $validators = $this->getValidator()->getValidators();
        $this->assertNotEmpty($validators);
        $this->assertEquals('Name', $validators[0][0]);
        $this->assertInstanceOf(PresenceOf::class, $validators[0][1]);
    }
}
