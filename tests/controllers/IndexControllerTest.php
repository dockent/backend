<?php

namespace Dockent\Tests\controllers;

use Dockent\controllers\IndexController;
use Exception;
use Phalcon\Http\ResponseInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexControllerTest
 * @package Dockent\Tests\controllers
 */
class IndexControllerTest extends TestCase
{
    public function testIndexAction()
    {
        $this->expectOutputString('');
        $controller = new IndexController();
        $controller->beforeExecuteRoute();
        $controller->indexAction();
    }

    /**
     * @throws Exception
     */
    public function testApplicationConfigAction()
    {
        $controller = new IndexController();
        $controller->beforeExecuteRoute();
        $result = $controller->applicationConfigAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('debugMode', $encodedResult);
    }
}