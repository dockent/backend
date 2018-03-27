<?php

namespace Dockent\Tests\components;

use Dockent\components\DI as DIFactory;
use Dockent\components\queue\IQueueActions;
use Dockent\components\QueueActions;
use Dockent\enums\DI;
use Dockent\models\CreateContainer;
use Dockent\models\DockerfileBuilder;
use Dockent\Tests\mocks\Connector;
use PHPUnit\Framework\TestCase;

/**
 * Class QueueActionsTest
 * @package Dockent\Tests\components
 */
class QueueActionsTest extends TestCase
{
    /**
     * @var IQueueActions
     */
    private $instance;

    public function setUp()
    {
        DIFactory::getDI()->set(DI::DOCKER, function () {
            return new Connector();
        });
        $this->instance = new QueueActions();
    }

    public function testCreateContainer()
    {
        $this->expectOutputString('');
        $model = new CreateContainer();
        $model->assign([
            'Image' => 'ubuntu:latest',
            'Cmd' => 'bash',
            'Name' => 'MyContainer',
            'Start' => true
        ]);
        $this->instance->createContainer($model);
    }

    public function testStopContainer()
    {
        $this->expectOutputString('');
        $this->instance->stopContainer('some-container');
    }

    public function testRestartAction()
    {
        $this->expectOutputString('');
        $this->instance->restartAction('some-container');
    }

    /**
     * @throws \Exception
     */
    public function testBuildImageByDockerfilePath()
    {
        $this->expectOutputString('');
        $this->instance->buildImageByDockerfilePath('/var/www');
    }

    /**
     * @throws \Exception
     */
    public function testBuildByDockerfileBodyAction()
    {
        $this->expectOutputString('');
        $this->instance->buildByDockerfileBodyAction('');
    }

    /**
     * @throws \Exception
     */
    public function testBuildByContext()
    {
        $this->expectOutputString('');
        $this->instance->buildByContext(new DockerfileBuilder());
    }
}