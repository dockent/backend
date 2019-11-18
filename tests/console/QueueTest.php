<?php

namespace Dockent\Tests\console;

use Dockent\console\Queue;
use Dockent\models\db\NotificationsInterface;
use Dockent\queue\QueueActionInterface;
use Dockent\Tests\mocks\Requests;
use Exception;
use GuzzleHttp\Psr7\Response;
use Phalcon\Di;
use Phalcon\DiInterface;
use Phalcon\Logger\AdapterInterface;
use Phalcon\Queue\Beanstalk;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Http\Client\Exception\HttpException;

/**
 * Class QueueTest
 *
 * @package Dockent\Tests\console
 */
class QueueTest extends TestCase
{
    /**
     * @var MockObject|Beanstalk
     */
    private $beanstalkdMock;

    /**
     * @var MockObject|AdapterInterface
     */
    private $loggerMock;

    /**
     * @var MockObject|NotificationsInterface
     */
    private $notificationMock;

    /**
     * @var Queue
     */
    private $instance;

    protected function setUp()
    {
        $this->beanstalkdMock = $this->getMockBuilder(Beanstalk::class)->getMock();
        $this->loggerMock = $this->getMockBuilder(AdapterInterface::class)->getMock();
        $this->notificationMock = $this->getMockBuilder(NotificationsInterface::class)->getMock();

        $this->instance = new Queue(Di::getDefault(), $this->beanstalkdMock, $this->loggerMock, $this->notificationMock);
    }

    public function testRunWithExit()
    {
        $this->expectOutputString('');
        $this->beanstalkdMock->method('reserve')->willReturn(false);
        $this->instance->start();
    }

    public function testRunWithException()
    {
        $this->expectOutputString('');
        $jobMock = $this->getMockBuilder(Beanstalk\Job::class)->disableOriginalConstructor()->getMock();
        $jobMock->method('getBody')->willReturn([
            'action' => null,
        ]);
        $jobMock->method('delete')->willReturn(true);
        $this->beanstalkdMock->method('reserve')->willReturn($jobMock, false);
        /** @var MockObject|DiInterface $diMock */
        $diMock = $this->getMockBuilder(Di::class)->disableOriginalConstructor()->getMock();
        $diMock->method('get')->willThrowException(new Exception());

        $this->loggerMock->method('error')->willReturnSelf();

        $instance = new Queue($diMock, $this->beanstalkdMock, $this->loggerMock, $this->notificationMock);
        $instance->start();
    }

    public function testRunWithHttpException()
    {
        $this->expectOutputString('');
        $jobMock = $this->getMockBuilder(Beanstalk\Job::class)->disableOriginalConstructor()->getMock();
        $jobMock->method('getBody')->willReturn([
            'action' => null,
        ]);
        $jobMock->method('delete')->willReturn(true);
        $this->beanstalkdMock->method('reserve')->willReturn($jobMock, false);
        /** @var MockObject|DiInterface $diMock */
        $diMock = $this->getMockBuilder(Di::class)->disableOriginalConstructor()->getMock();
        $diMock->method('get')->willThrowException(new HttpException('', new Requests(), new Response()));

        $this->loggerMock->method('error')->willReturnSelf();
        $this->notificationMock->method('createNotify')->willReturn(true);

        $instance = new Queue($diMock, $this->beanstalkdMock, $this->loggerMock, $this->notificationMock);
        $instance->start();
    }

    public function testRunWithoutException()
    {
        $this->expectOutputString('');
        $jobMock = $this->getMockBuilder(Beanstalk\Job::class)->disableOriginalConstructor()->getMock();
        $jobMock->method('getBody')->willReturn([
            'action' => null,
        ]);
        $jobMock->method('delete')->willReturn(true);
        $this->beanstalkdMock->method('reserve')->willReturn($jobMock, false);
        $actionMock = $this->getMockBuilder(QueueActionInterface::class)->getMock();
        $actionMock->method('setData')->willReturnSelf();
        $actionMock->method('handle')->willReturn(null);
        /** @var MockObject|DiInterface $diMock */
        $diMock = $this->getMockBuilder(Di::class)->disableOriginalConstructor()->getMock();
        $diMock->method('get')->willReturn($actionMock);

        $instance = new Queue($diMock, $this->beanstalkdMock, $this->loggerMock, $this->notificationMock);
        $instance->start();
    }
}