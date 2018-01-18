<?php

namespace Dockent\Tests\controllers;

use Dockent\components\DI as DIFactory;
use Dockent\controllers\BuilderController;
use Dockent\enums\DI;
use Phalcon\Annotations\AdapterInterface;
use Phalcon\Http\ResponseInterface;

/**
 * Class BuilderControllerTest
 * @package Dockent\Tests\controllers
 */
class BuilderControllerTest extends ControllerTestCase
{
    /**
     * @var BuilderController
     */
    private $instance;

    public function setUp()
    {
        parent::setUp();
        $this->instance = new BuilderController();
        $this->instance->beforeExecuteRoute();
    }

    public function testBuildByDockerfilePathActionWithErrors()
    {
        $result = $this->instance->buildByDockerfilePathAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('error', $encodedResult['status']);
        $this->assertArrayHasKey('errors', $encodedResult);
        $this->assertInternalType('array', $encodedResult['errors']);
        $this->assertNotEmpty($encodedResult['errors']);
    }

    public function testBuildByDockerfilePathActionWithoutErrors()
    {
        $_POST = [
            'dockerfilePath' => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'dummy'
        ];
        $result = $this->instance->buildByDockerfilePathAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
        $this->assertArrayHasKey('message', $encodedResult);
        $this->assertEquals('Action sent to queue', $encodedResult['message']);
    }

    public function testBuildByDockerfileBodyActionWithErrors()
    {
        $result = $this->instance->buildByDockerfileBodyAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('error', $encodedResult['status']);
        $this->assertArrayHasKey('errors', $encodedResult);
        $this->assertInternalType('array', $encodedResult['errors']);
        $this->assertNotEmpty($encodedResult['errors']);
    }

    public function testBuildByDockerfileBodyActionWithoutErrors()
    {
        $_POST = [
            'dockerfileBody' => 'FROM busybox'
        ];
        $result = $this->instance->buildByDockerfileBodyAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
        $this->assertArrayHasKey('message', $encodedResult);
        $this->assertEquals('Action sent to queue', $encodedResult['message']);
    }

    public function testIndexActionWithErrors()
    {
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('error', $encodedResult['status']);
        $this->assertArrayHasKey('errors', $encodedResult);
        $this->assertInternalType('array', $encodedResult['errors']);
        $this->assertNotEmpty($encodedResult['errors']);
    }

    public function testIndexActionWithoutErrors()
    {
        $_POST = [
            'from' => 'busybox'
        ];
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
        $this->assertArrayHasKey('message', $encodedResult);
        $this->assertEquals('Action sent to queue', $encodedResult['message']);
    }

    public function testMethodAnnotations()
    {
        /** @var AdapterInterface $annotationsAdapter */
        $annotationsAdapter = DIFactory::getDI()->get(DI::ANNOTATIONS);
        $methods = ['buildByDockerfilePathAction', 'buildByDockerfileBodyAction', 'indexAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(BuilderController::class, $methodName);
            $this->assertTrue($method->has('Method'));
            $this->assertEquals(['POST'], $method->get('Method')->getArguments());
        }
    }
}