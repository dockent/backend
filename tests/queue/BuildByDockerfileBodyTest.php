<?php

namespace Dockent\Tests\queue;

use Dockent\queue\BuildByDockerfileBody;
use Dockent\queue\BuildImageByDockerfilePath;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class BuildByDockerfileBodyTest
 *
 * @package Dockent\Tests\queue
 */
class BuildByDockerfileBodyTest extends TestCase
{
    /**
     * @var BuildByDockerfileBody
     */
    private $instance;

    protected function setUp()
    {
        /** @var MockObject|BuildImageByDockerfilePath $buildActionMock */
        $buildActionMock = $this->getMockBuilder(BuildImageByDockerfilePath::class)->disableOriginalConstructor()->getMock();
        $buildActionMock->method('setData')->willReturnSelf();
        $buildActionMock->expects($this->once())->method('handle');
        $this->instance = new BuildByDockerfileBody($buildActionMock);
    }

    public function testHandle()
    {
        $this->expectOutputString('');
        $this->instance->setData('file');
        $this->instance->handle();
    }
}