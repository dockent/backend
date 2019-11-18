<?php

namespace Dockent\Tests\controllers;

use Dockent\components\config\Config;
use Dockent\controllers\SettingsController;
use Dockent\Tests\mocks\Requests;
use Phalcon\Annotations\AdapterInterface;
use Phalcon\Di;
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

    /**
     * @throws Exception
     */
    public function setUp()
    {
        putenv('DOCKENT_DEBUG=true');
        parent::setUp();
        $this->instance = new SettingsController();
        Di::getDefault()->set(Config::class, function () {
            return new Config('./tests/dummy/config.php');
        });
        $this->instance->beforeExecuteRoute();
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
        $request = new Requests();
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
        $request = new Requests();
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

    /**
     * @throws \Exception
     */
    public function testMethodAnnotations()
    {
        /** @var AdapterInterface $annotationsAdapter */
        $annotationsAdapter = Di::getDefault()->get(AdapterInterface::class);
        /**
         * POST methods
         */
        $methods = ['indexAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(SettingsController::class, $methodName);
            $this->assertTrue($method->has('Method'));
            $this->assertEquals(['GET', 'POST'], $method->get('Method')->getArguments());
        }
    }

    public function tearDown()
    {
        putenv('DOCKENT_DEBUG');
    }
}