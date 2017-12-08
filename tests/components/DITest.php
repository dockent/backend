<?php

namespace Dockent\Tests\components;

use Dockent\components\DI;
use Phalcon\DiInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class DITest
 */
class DITest extends TestCase
{
    public function testGetDI()
    {
        $this->assertInstanceOf(DiInterface::class, DI::getDI());
    }
}