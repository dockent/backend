<?php

namespace Dockent\Tests\components;

use Dockent\components\DI as DIFactory;
use Dockent\components\Docker;
use Dockent\enums\DI;
use Dockent\Tests\dataProviders\DockerfileBody;
use Dockent\Tests\mocks\Connector;
use PHPUnit\Framework\TestCase;

/**
 * Class DockerTest
 */
class DockerTest extends TestCase
{
    use DockerfileBody;

    public function setUp()
    {
        DIFactory::getDI()->set(DI::DOCKER, function () {
            return new Connector();
        });
    }

    /**
     * @dataProvider dataProviderGenerateBody
     * @param array $parameters
     * @param string $body
     */
    public function testGenerateBody(array $parameters, string $body)
    {
        $this->assertEquals($body, Docker::generateBody($parameters));
    }

    public function testPullWithTag()
    {
        $this->expectOutputString('');
        Docker::pull('ubuntu:latest');
    }

    public function testPullWithoutTag()
    {
        $this->expectOutputString('');
        Docker::pull('ubuntu');
    }
}
