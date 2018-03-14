<?php

namespace Dockent\Tests\controllers;

use Dockent\components\DI as DIFactory;
use Dockent\components\config\Config;
use Dockent\controllers\SettingsController;
use Dockent\enums\DI;
use Dockent\Tests\mocks\Requests;
use Phalcon\Http\Request\Exception;
use Phalcon\Http\ResponseInterface;

/**
 * Class SettingsControllerTest
 * @package Dockent\Tests\controllers
 */
class SettingsControllerTest extends ControllerTestCase
{
    /**
     * @var SettingsController
     */
    private $instance;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new SettingsController();
        DIFactory::getDI()->set(DI::CONFIG, function () {
            return new Config('./tests/dummy/config.php');
        });
        DIFactory::getDI()->set(DI::REQUEST, new Requests());
    }

    /**
     * @throws Exception
     */
    public function testBeforeExecuteRoute()
    {
        putenv('DOCKENT_DEBUG');
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Page not found');
        $this->expectExceptionCode(404);
        $this->instance->beforeExecuteRoute();
    }

    /**
     * @throws Exception
     */
    public function testBeforeExecuteRouteWithDebugMode()
    {
        putenv('DOCKENT_DEBUG=true');
        $this->expectOutputString('');
        $this->instance->beforeExecuteRoute();
    }

    /**
     * @throws \Exception
     */
    public function testIndexAction()
    {
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('model', $encodedResult);
    }

    /**
     * @throws \Exception
     */
    public function testIndexActionPostWithoutErrors()
    {
        /** @var Requests $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
        $request->setPost();
        $request->setRawBody('{}');
        $this->instance->request = $request;
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
    }

    /**
     * @throws \Exception
     */
    public function testIndexActionPostWithErrors()
    {
        /** @var Requests $request */
        $request = DIFactory::getDI()->get(DI::REQUEST);
        $request->setPost();
        $request->setRawBody('{"beanstalkPort":"abc"}');
        $this->instance->request = $request;
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('error', $encodedResult['status']);
        $this->assertArrayHasKey('errors', $encodedResult);
        $this->assertNotEmpty($encodedResult['errors']);
    }
}