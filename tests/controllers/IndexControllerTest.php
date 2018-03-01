<?php

namespace Dockent\Tests\controllers;

use Dockent\controllers\IndexController;
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
        (new IndexController())->indexAction();
    }

    /**
     * @throws \Exception
     */
    public function testApplicationConfigAction()
    {
        $result = (new IndexController())->applicationConfigAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('debugMode', $encodedResult);
    }
}