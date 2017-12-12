<?php

namespace Dockent\Tests\mocks;

use Dockent\components\BulkAction;
use Dockent\components\Controller;

/**
 * Class BulkController
 * @package Dockent\Tests\mocks
 */
class BulkController extends Controller
{
    use BulkAction;

    public function fakeAction()
    {
    }

    /**
     * @Bulk
     */
    public function correctAction()
    {
    }
}