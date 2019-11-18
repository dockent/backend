<?php

namespace Dockent\Tests\controllers;

use Dockent\controllers\NotificationsController;
use Dockent\models\db\NotificationsInterface;
use Dockent\Tests\mocks\Requests;
use Phalcon\Di;
use Phalcon\Http\ResponseInterface;

/**
 * Class NotificationsControllerTest
 *
 * @package Dockent\Tests\controllers
 */
class NotificationsControllerTest extends ControllerTestCase
{
    /**
     * @var NotificationsController
     */
    private $instance;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new NotificationsController();

        $notificationsMock = $this->getMockBuilder(NotificationsInterface::class)->setMethods([
            'getUnreadCount',
            'deleteByIds',
            'createNotify',
            'getNotifications',
            'markAsUnread',
        ])->getMock();
        $notificationsMock->method('getUnreadCount')->willReturn(0);

        Di::getDefault()->set(NotificationsInterface::class, $notificationsMock);

        $this->instance->beforeExecuteRoute();
    }

    public function testIndexAction()
    {
        $request = new Requests();
        $this->instance->request = $request;
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
    }

    public function testDeleteAction()
    {
        $request = new Requests();
        $request->setRawBody('{"id":[]}');
        $this->instance->request = $request;
        $result = $this->instance->deleteAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $decodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $decodedResult);
    }

    public function testMarkAsUnreadAction()
    {
        $request = new Requests();
        $request->setRawBody('{"id":1}');
        $this->instance->request = $request;
        $result = $this->instance->markAsUnreadAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $decodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $decodedResult);
    }

    public function testUnreadCountAction()
    {
        $result = $this->instance->unreadCountAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $decodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('count', $decodedResult);
        $this->assertInternalType('int', $decodedResult['count']);
    }
}