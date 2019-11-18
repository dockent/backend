<?php

namespace Dockent\Tests\components;

use Dockent\exceptions\ErrorExceptionHandler;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use ReflectionMethod;

/**
 * Class ErrorExceptionHandlerTest
 * @package Dockent\Tests\components
 */
class ErrorExceptionHandlerTest extends TestCase
{
    /**
     * @var \stdClass
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new class {
            use ErrorExceptionHandler;
        };
    }

    /**
     * @throws ReflectionException
     */
    public function testExceptionErrorHandler()
    {
        $method = new ReflectionMethod($this->instance, 'exceptionErrorHandler');
        $method->setAccessible(true);
        $this->expectException(\ErrorException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Exception Test');
        $method->invokeArgs($this->instance, [E_WARNING, 'Exception Test', 'test.php', 10]);
    }

    /**
     * @throws ReflectionException
     */
    public function testWithErrorReportingIgnore()
    {
        $this->expectOutputString('');
        $method = new ReflectionMethod($this->instance, 'exceptionErrorHandler');
        $method->setAccessible(true);
        $method->invokeArgs($this->instance, [0, 'Exception Test', 'test.php', 10]);
    }
}