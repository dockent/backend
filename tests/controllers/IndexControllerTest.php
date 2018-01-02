<?php

namespace Dockent\Tests\controllers;

use Dockent\controllers\IndexController;
use Phalcon\Http\ResponseInterface;

/**
 * Class IndexControllerTest
 * @package Dockent\Tests\controllers
 */
class IndexControllerTest extends ControllerTestCase
{

    /**
     * @var IndexController
     */
    private $instance;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new IndexController();
        $this->instance->beforeExecuteRoute();
    }

    public function testIndexAction()
    {
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
    }
}