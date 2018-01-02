<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 28.08.17
 * Time: 07:47
 */

namespace Dockent\components;

use Dockent\components\DI as DIFactory;
use Dockent\Connector\Connector;
use Dockent\enums\DI;
use Phalcon\Annotations\AdapterInterface;
use Phalcon\Mvc\Controller as PhalconController;

/**
 * Class Controller
 * @package Dockent\components
 */
class Controller extends PhalconController
{
    /**
     * @var Connector
     */
    protected $docker;

    /**
     * @var bool
     */
    static $DEBUG_MODE = false;

    /**
     * @return bool
     */
    public function beforeExecuteRoute(): bool
    {
        $this->docker = DIFactory::getDI()->get(DI::DOCKER);
        static::$DEBUG_MODE = (bool)getenv('DOCKENT_DEBUG');

        /** @var AdapterInterface $annotationsAdapted */
        $annotationsAdapted = DIFactory::getDI()->get(DI::ANNOTATIONS);
        $methodAnnotations = $annotationsAdapted->getMethod(static::class, $this->dispatcher->getActionName());
        if ($methodAnnotations->has('Method')) {
            $args = $methodAnnotations->get('Method')->getArguments();
            if ($this->request->isGet()) {
                return in_array('GET', $args);
            }
            if ($this->request->isPost()) {
                return in_array('POST', $args);
            }
            if ($this->request->isPut()) {
                return in_array('PUT', $args);
            }
            if ($this->request->isDelete()) {
                return in_array('DELETE', $args);
            }
        }

        return true;
    }

    /**
     * @param string $url
     */
    public function redirect(string $url)
    {
        http_response_code(302);
        header("Location: $url");
    }
}