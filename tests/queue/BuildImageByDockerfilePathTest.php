<?php

namespace Dockent\Tests\queue;

use Dockent\models\db\NotificationsInterface;
use Dockent\queue\BuildImageByDockerfilePath;
use Dockent\Tests\mocks\Connector;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class BuildImageByDockerfilePathTest
 *
 * @package Dockent\Tests\queue
 */
class BuildImageByDockerfilePathTest extends TestCase
{
    /**
     * @var BuildImageByDockerfilePath
     */
    private $instance;

    protected function setUp()
    {
        /** @var MockObject|NotificationsInterface $notificationMock */
        $notificationMock = $this->getMockBuilder(NotificationsInterface::class)->getMock();
        $notificationMock->method('createNotify')->willReturn(true);
        $this->instance = new BuildImageByDockerfilePath(new Connector(), $notificationMock);
    }

    /**
     * @throws Exception
     */
    public function testHandle()
    {
        $this->expectOutputString('');
        $this->instance->handle();
    }
}