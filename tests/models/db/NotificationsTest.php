<?php

namespace Dockent\Tests\models\db;

use Dockent\enums\NotificationStatus;
use Dockent\models\db\Notifications;
use PHPUnit\Framework\TestCase;

/**
 * Class NotificationsTest
 * @package Dockent\Tests\models\db
 */
class NotificationsTest extends TestCase
{
    /**
     * @var Notifications
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new Notifications();
    }

    public function testSetAndGetId()
    {
        $this->instance->setId(1);
        $result = $this->instance->getId();
        $this->assertEquals(1, $result);
        $this->assertIsInt($result);
    }

    public function testSetAndGetText()
    {
        $this->instance->setText('some string');
        $result = $this->instance->getText();
        $this->assertEquals('some string', $result);
        $this->assertIsString($result);
    }

    public function testSetAndGetIsViewed()
    {
        $this->instance->setViewed(true);
        $result = $this->instance->isViewed();
        $this->assertTrue($result);
        $this->assertIsBool($result);
    }

    public function testSetAndGetStatus()
    {
        $this->instance->setStatus(NotificationStatus::ERROR);
        $result = $this->instance->getStatus();
        $this->assertEquals(NotificationStatus::ERROR, $result);
        $this->assertIsInt($result);
    }

    public function testSetAndGetTime()
    {
        $this->instance->setTime(123);
        $result = $this->instance->getTime();
        $this->assertEquals(123, $result);
        $this->assertIsInt($result);
    }
}