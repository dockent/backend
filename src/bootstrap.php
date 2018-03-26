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
use Dockent\enums\Events;
use Dockent\models\db\Notifications;
use Phalcon\Annotations\Adapter\Memory as Annotations;
use Dockent\components\config\Config;
use Phalcon\Db\Adapter\Pdo\Factory as PdoFactory;
use Phalcon\Events\Manager;
use Phalcon\Http\Request;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Queue\Beanstalk;
use Vados\PhalconPlugins\HTTPMethodsPlugin;
use Vados\TCPLogger\Adapter;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/app/components/functions.php';

$loader = new Loader();
$loader->register();

DIFactory::getDI()->set(DI::REQUEST, function () {
    return new Request();
});
DIFactory::getDI()->set(DI::EVENTS_MANAGER, function () {
    return new Manager();
});
DIFactory::getDI()->set(DI::DISPATCHER, function () {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Dockent\controllers');

    /** @var Manager $eventsManager */
    $eventsManager = DIFactory::getDI()->get(DI::EVENTS_MANAGER);
    $eventsManager->attach(Events::DISPATCH_BEFORE_EXECUTE_ROUTE, new HTTPMethodsPlugin());

    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});
DIFactory::getDI()->set(DI::VIEW, function () {
    $view = new View();
    $view->setViewsDir(__DIR__ . '/app/views');

    return $view;
});
DIFactory::getDI()->set(DI::CONFIG, function () {
    return new Config(__DIR__ . '/app/config.php');
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
DIFactory::getDI()->set(DI::LOGGER, function () {
    /** @var Config $config */
    $config = DIFactory::getDI()->get(DI::CONFIG);
    return new Adapter($config->path('logstash.host'), $config->path('logstash.port'));
});
DIFactory::getDI()->set(DI::DB, function () {
    /** @var Config $config */
    $config = DIFactory::getDI()->get(DI::CONFIG);
    return PdoFactory::load($config->get('database'));
});
DIFactory::getDI()->set(DI::NOTIFICATIONS, function () {
    return new Notifications();
});