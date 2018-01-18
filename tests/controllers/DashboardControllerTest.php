<?php

namespace Dockent\Tests\controllers;

use Dockent\controllers\DashboardController;
use Phalcon\Http\ResponseInterface;

/**
 * Class IndexControllerTest
 * @package Dockent\Tests\controllers
 */
class DashboardControllerTest extends ControllerTestCase
{

    /**
     * @var DashboardController
     */
    private $instance;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new DashboardController();
        $this->instance->beforeExecuteRoute();
    }

    public function testIndexAction()
    {
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
    }
}