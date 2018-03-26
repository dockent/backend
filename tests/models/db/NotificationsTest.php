<?php

namespace Dockent\Tests\models\db;

use Dockent\models\db\Notifications;

/**
 * Class NotificationsTest
 * @package Dockent\Tests\models\db
 */
class NotificationsTest extends ModelTestCase
{
    /**
     * @var Notifications
     */
    private $instance;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new Notifications();
    }

    public function testSetAndGetId()
    {
        $this->instance->setId(1);
        $result = $this->instance->getId();
        $this->assertEquals(1, $result);
        $this->assertInternalType('int', $result);
    }

    public function testSetAndGetText()
    {
        $this->instance->setText('some string');
        $result = $this->instance->getText();
        $this->assertEquals('some string', $result);
        $this->assertInternalType('string', $result);
    }

    public function testDeleteByIds()
    {
        $this->assertTrue($this->instance->deleteByIds(['10']));
    }

    public function testCreateNotify()
    {
        $this->assertInternalType('bool', $this->instance->createNotify('some notify'));
    }
}