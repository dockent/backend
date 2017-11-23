<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 15:41
 */

use Dockent\components\DI as DIFactory;
use Dockent\Connector\Connector;
use Dockent\enums\DI;
use Phalcon\Annotations\Adapter\Memory as Annotations;
use Dockent\components\config\Config;
use Phalcon\Debug;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Queue\Beanstalk;

$loader = new Loader();
$loader->registerNamespaces([
    'Dockent' => './app/'
]);
$loader->register();

(new Debug())->listen();

DIFactory::getDI()->set(DI::DISPATCHER, function () {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Dockent\controllers');

    return $dispatcher;
});
DIFactory::getDI()->set(DI::VIEW, function () {
    $view = new View();
    $view->setViewsDir('./app/views');

    return $view;
});
DIFactory::getDI()->set(DI::CONFIG, function () {
    return new Config(require './app/config.php');
});
DIFactory::getDI()->set(DI::DOCKER, function () {
    return new Connector();
});
DIFactory::getDI()->set(DI::QUEUE, function () {
    /** @var Config $config */
    $config = DIFactory::getDI()->get(DI::CONFIG);
    return new Beanstalk([
        'host' => $config->path('queue.host'),
        'port' => $config->path('queue.port')
    ]);
});
DIFactory::getDI()->set(DI::ANNOTATIONS, function () {
    return new Annotations();
});