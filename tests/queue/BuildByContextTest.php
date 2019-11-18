<?php

namespace Dockent\Tests\queue;

use Dockent\components\docker\BodyGenerator;
use Dockent\models\DockerfileBuilder;
use Dockent\queue\BuildByContext;
use Dockent\queue\BuildByDockerfileBody;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class BuildByContextTest
 *
 * @package Dockent\Tests\queue
 */
class BuildByContextTest extends TestCase
{
    /**
     * @var BuildByContext
     */
    private $instance;

    protected function setUp()
    {
        /** @var MockObject|BuildByDockerfileBody $buildActionMock */
        $buildActionMock = $this->getMockBuilder(BuildByDockerfileBody::class)->disableOriginalConstructor()->getMock();
        $buildActionMock->method('setData')->willReturnSelf();
        $buildActionMock->expects($this->once())->method('handle');
        $this->instance = new BuildByContext(new BodyGenerator(), $buildActionMock);
    }

    public function testHandle()
    {
        $this->expectOutputString('');
        $this->instance->setData(new DockerfileBuilder());
        $this->instance->handle();
    }
}