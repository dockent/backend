<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 02.01.18
 * Time: 10:33
 */

namespace Dockent\Tests\mocks;

use Dockent\components\Controller;

/**
 * Class TestController
 * @package mocks
 */
class TestController extends Controller
{
    public function indexAction()
    {

    }

    /**
     * @Method(GET)
     */
    public function onlyGetAction()
    {

    }

    /**
     * @Method(POST)
     */
    public function onlyPostAction()
    {

    }

    /**
     * @Method(PUT)
     */
    public function onlyPutAction()
    {

    }

    /**
     * @Method(DELETE)
     */
    public function onlyDeleteAction()
    {

    }

    /**
     * @Method(GET, POST)
     */
    public function fewMethodsAction()
    {

    }
}