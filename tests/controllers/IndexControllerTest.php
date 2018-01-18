<?php

namespace Dockent\Tests\controllers;

use Dockent\controllers\IndexController;
use PHPUnit\Framework\TestCase;

/**
 * Class IndexControllerTest
 * @package Dockent\Tests\controllers
 */
class IndexControllerTest extends TestCase
{
    public function testIndexAction()
    {
        $this->expectOutputString('');
        (new IndexController())->indexAction();
    }
}