<?php

namespace Dockent\Tests\controllers;

use Dockent\Connector\Connector;
use Dockent\Tests\mocks\Connector as ConnectorMock;
use Phalcon\Di;
use Phalcon\Queue\Beanstalk;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class ControllerTestCase
 *
 * @package Dockent\Tests\controllers
 */
class ControllerTestCase extends TestCase
{
    /**
     * @var MockObject|Beanstalk
     */
    protected $queueMock;

    public function setUp()
    {
        Di::getDefault()->remove(Connector::class);
        Di::getDefault()->setShared(Connector::class, ConnectorMock::class);

        $this->queueMock = $this->getMockBuilder(Beanstalk::class)->disableOriginalConstructor()->getMock();
        Di::getDefault()->setShared(Beanstalk::class, $this->queueMock);
    }
}