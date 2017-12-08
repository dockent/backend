<?php

namespace Dockent\Tests\components;

use Dockent\components\Docker;
use Dockent\Tests\dataProviders\DockerfileBody;
use PHPUnit\Framework\TestCase;

/**
 * Class DockerTest
 */
class DockerTest extends TestCase
{
    use DockerfileBody;

    /**
     * @dataProvider dataProviderGenerateBody
     * @param array $parameters
     * @param string $body
     */
    public function testGenerateBody(array $parameters, string $body)
    {
        $this->assertEquals($body, Docker::generateBody($parameters));
    }
}
