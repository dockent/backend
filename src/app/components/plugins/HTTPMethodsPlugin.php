<?php

namespace Dockent\components\plugins;

use Dockent\enums\DI;
use Phalcon\Annotations\AdapterInterface;
use Phalcon\Events\Event;
use Phalcon\Http\RequestInterface;
use Phalcon\Mvc\Dispatcher;
use Dockent\components\DI as DIFactory;

/**
 * Class HTTPMethodsPlugin
 * @package Dockent\components\plugins
 */
class HTTPMethodsPlugin
{
    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @return bool
     */
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher): bool
    {
        /** @var AdapterInterface $annotationsAdapter */
        $annotationsAdapter = DIFactory::getDI()->get(DI::ANNOTATIONS);
        $methodAnnotations = $annotationsAdapter->getMethod($dispatcher->getControllerClass(),
            $dispatcher->getActionName() . 'Action');
        if ($methodAnnotations->has('Method')) {
            $args = $methodAnnotations->get('Method')->getArguments();
            /** @var RequestInterface $request */
            $request = DIFactory::getDI()->get(DI::REQUEST);
            if ($request->isGet()) {
                return in_array('GET', $args);
            }
            if ($request->isPost()) {
                return in_array('POST', $args);
            }
            if ($request->isPut()) {
                return in_array('PUT', $args);
            }
            if ($request->isDelete()) {
                return in_array('DELETE', $args);
            }
        }

        return true;
    }
}