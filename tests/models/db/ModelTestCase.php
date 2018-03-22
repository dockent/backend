<?php

namespace Dockent\Tests\models\db;

use Dockent\enums\DI;
use Dockent\Tests\mocks\Db;
use PHPUnit\Framework\TestCase;
use Dockent\components\DI as DIFactory;

/**
 * Class ModelTest
 * @package Dockent\Tests\models\db
 */
class ModelTestCase extends TestCase
{
    public function setUp()
    {
        DIFactory::getDI()->set(DI::DB, new Db());
    }
}