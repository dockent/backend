<?php

namespace Dockent\Tests\controllers;

use Dockent\controllers\BuilderController;
use Dockent\Tests\mocks\Requests;
use Exception;
use Phalcon\Annotations\AdapterInterface;
use Phalcon\Di;
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

    /**
     * @throws Exception
     */
    public function testBuildByDockerfilePathActionWithErrors()
    {
        $request = new Requests();
        $request->setRawBody('{}');
        $this->instance->request = $request;
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

    /**
     * @throws Exception
     */
    public function testBuildByDockerfilePathActionWithoutErrors()
    {
        $data = [
            'dockerfilePath' => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'dummy'
        ];
        $request = new Requests();
        $request->setRawBody(json_encode($data));
        $this->instance->request = $request;
        $result = $this->instance->buildByDockerfilePathAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
        $this->assertArrayHasKey('message', $encodedResult);
        $this->assertEquals('Action sent to queue', $encodedResult['message']);
    }

    /**
     * @throws Exception
     */
    public function testBuildByDockerfileBodyActionWithErrors()
    {
        $request = new Requests();
        $request->setRawBody('{}');
        $this->instance->request = $request;
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

    /**
     * @throws Exception
     */
    public function testBuildByDockerfileBodyActionWithoutErrors()
    {
        $data = [
            'dockerfileBody' => 'FROM busybox'
        ];
        $request = new Requests();
        $request->setRawBody(json_encode($data));
        $this->instance->request = $request;
        $result = $this->instance->buildByDockerfileBodyAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
        $this->assertArrayHasKey('message', $encodedResult);
        $this->assertEquals('Action sent to queue', $encodedResult['message']);
    }

    /**
     * @throws Exception
     */
    public function testIndexActionWithErrors()
    {
        $request = new Requests();
        $request->setRawBody('{}');
        $this->instance->request = $request;
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

    /**
     * @throws Exception
     */
    public function testIndexActionWithoutErrors()
    {
        $data = [
            'from' => 'busybox'
        ];
        $request = new Requests();
        $request->setRawBody(json_encode($data));
        $this->instance->request = $request;
        $result = $this->instance->indexAction();
        $this->assertInstanceOf(ResponseInterface::class, $result);
        $this->assertThat($result->getContent(), $this->isJson());
        $encodedResult = json_decode($result->getContent(), true);
        $this->assertArrayHasKey('status', $encodedResult);
        $this->assertEquals('success', $encodedResult['status']);
        $this->assertArrayHasKey('message', $encodedResult);
        $this->assertEquals('Action sent to queue', $encodedResult['message']);
    }

    /**
     * @throws Exception
     */
    public function testMethodAnnotations()
    {
        /** @var AdapterInterface $annotationsAdapter */
        $annotationsAdapter = Di::getDefault()->get(AdapterInterface::class);
        $methods = ['buildByDockerfilePathAction', 'buildByDockerfileBodyAction', 'indexAction'];
        foreach ($methods as $methodName) {
            $method = $annotationsAdapter->getMethod(BuilderController::class, $methodName);
            $this->assertTrue($method->has('Method'));
            $this->assertEquals(['POST'], $method->get('Method')->getArguments());
        }
    }
}