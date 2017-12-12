<?php

namespace Dockent\Tests\components;

use Dockent\Tests\mocks\BulkController;
use Phalcon\Http\Request\Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class BulkActionTest
 * @package Dockent\Tests\components
 */
class BulkActionTest extends TestCase
{
    /**
     * @var BulkController
     */
    private $instance;

    public function setUp()
    {
        require './src/bootstrap.php';
        $this->instance = new BulkController();
        $_POST['id'] = [1];
    }

    /**
     * @throws Exception
     */
    public function testNotSupportedException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Action doesn\'t support Bulk');
        $this->instance->bulkAction('fake');
    }

    /**
     * @throws Exception
     */
    public function testNotFoundException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage('Action not found');
        $this->instance->bulkAction('invisible');
    }

    /**
     * @throws Exception
     */
    public function testBulkAction()
    {
        $this->expectOutputString('');
        $this->instance->bulkAction('correct');
    }
}