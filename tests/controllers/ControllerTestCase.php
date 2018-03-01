<?php

namespace Dockent\Tests\controllers;

use Dockent\enums\DI;
use Dockent\Tests\mocks\Connector;
use Dockent\Tests\mocks\Queue;
use Dockent\Tests\mocks\Requests;
use PHPUnit\Framework\TestCase;
use Dockent\components\DI as DIFactory;

/**
 * Class ControllerTestCase
 * @package Dockent\Tests\controllers
 */
class ControllerTestCase extends TestCase
{
    public function setUp()
    {
        DIFactory::getDI()->set(DI::DOCKER, new Connector());
        DIFactory::getDI()->set(DI::QUEUE, new Queue());
        DIFactory::getDI()->set(DI::REQUEST, new Requests());
    }
}