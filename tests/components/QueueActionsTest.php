<?php

namespace Dockent\Tests\components;

use Dockent\components\DI as DIFactory;
use Dockent\components\QueueActions;
use Dockent\enums\DI;
use Dockent\models\CreateContainer;
use Dockent\Tests\mocks\Connector;
use PHPUnit\Framework\TestCase;

/**
 * Class QueueActionsTest
 * @package Dockent\Tests\components
 */
class QueueActionsTest extends TestCase
{
    public function setUp()
    {
        DIFactory::getDI()->set(DI::DOCKER, function () {
            return new Connector();
        });
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
        QueueActions::createContainer($model);
    }

    public function testStopContainer()
    {
        $this->expectOutputString('');
        QueueActions::stopContainer('some-container');
    }

    public function testRestartAction()
    {
        $this->expectOutputString('');
        QueueActions::restartAction('some-container');
    }
}