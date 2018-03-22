<?php

namespace Dockent\Tests\controllers;

use Dockent\controllers\NotificationsController;
use Dockent\enums\DI;
use Dockent\Tests\mocks\Requests;
use Phalcon\Http\ResponseInterface;
use Dockent\components\DI as DIFactory;

/**
 * Class NotificationsControllerTest
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
    }

    public function testIndexAction()
    {
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
    }

    public function testIndexActionDeleteMethod()
    {
        /** @var Requests $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
        $request->setRawBody('{"id":[]}');
        $this->instance->request = $request;
        $request->setDelete();
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $decodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $decodedResult);
    }
}