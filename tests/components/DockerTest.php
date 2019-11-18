<?php

namespace Dockent\Tests\components;

use Dockent\components\docker\BodyGenerator;
use Dockent\components\docker\Docker;
use Dockent\models\DockerfileBuilder;
use Dockent\Tests\dataProviders\DockerfileBody;
use Dockent\Tests\mocks\Connector;
use PHPUnit\Framework\TestCase;

/**
 * Class DockerTest
 */
class DockerTest extends TestCase
{
    use DockerfileBody;

    /**
     * @var Docker
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new Docker(new Connector());
    }

    /**
     * @dataProvider dataProviderGenerateBody
     *
     * @param DockerfileBuilder $parameters
     * @param string            $body
     */
    public function testGenerateBody(DockerfileBuilder $parameters, string $body)
    {
        $instance = new BodyGenerator();
        $this->assertEquals($body, $instance->generateBody($parameters));
    }

    public function testPullWithTag()
    {
        $this->expectOutputString('');

        $this->instance->pull('ubuntu:latest');
    }

    public function testPullWithoutTag()
    {
        $this->expectOutputString('');
        $this->instance->pull('ubuntu');
    }
}
