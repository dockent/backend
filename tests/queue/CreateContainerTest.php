<?php

namespace Dockent\Tests\queue;

use Dockent\components\docker\Docker;
use Dockent\models\CreateContainer as CreateContainerModel;
use Dockent\models\db\NotificationsInterface;
use Dockent\queue\CreateContainer;
use Dockent\Tests\mocks\Connector;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class CreateContainerTest
 *
 * @package Dockent\Tests\queue
 */
class CreateContainerTest extends TestCase
{
    /**
     * @var CreateContainer
     */
    private $instance;

    protected function setUp()
    {
        /** @var MockObject|Docker $dockerMock */
        $dockerMock = $this->getMockBuilder(Docker::class)->disableOriginalConstructor()->getMock();
        $dockerMock->method('pull')->willReturn(true);
        /** @var MockObject|NotificationsInterface $notificationMock */
        $notificationMock = $this->getMockBuilder(NotificationsInterface::class)->getMock();
        $notificationMock->method('createNotify')->willReturn(true);
        $this->instance = new CreateContainer(new Connector(), $dockerMock, $notificationMock);
    }

    public function testHandle()
    {
        $this->expectOutputString('');
        $data = new CreateContainerModel();
        $data->setName('name');
        $data->setStart(true);
        $this->instance->setData($data)->handle();
    }
}