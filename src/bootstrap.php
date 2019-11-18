<?php

use Dockent\components\docker\Docker;
use Dockent\Connector\Connector;
use Dockent\console\Queue;
use Dockent\enums\Events;
use Dockent\models\db\Notifications;
use Dockent\models\db\NotificationsInterface;
use Phalcon\Annotations\Adapter\Memory as Annotations;
use Dockent\components\config\Config;
use Phalcon\Annotations\AdapterInterface as AnnotationsAdapterInterface;
use Phalcon\Db\Adapter\Pdo\Factory as PdoFactory;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\ManagerInterface as EventsManagerInterface;
use Phalcon\Loader;
use Phalcon\Logger\AdapterInterface as LoggerAdapterInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\DispatcherInterface;
use Phalcon\Mvc\View;
use Phalcon\Queue\Beanstalk;
use Vados\PhalconPlugins\HTTPMethodsPlugin;
use Vados\TCPLogger\Adapter as LoggerAdapter;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/app/components/functions.php';

$loader = new Loader();
$loader->register();

$di = new FactoryDefault();

$di->set(DispatcherInterface::class, function () use ($di) {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Dockent\controllers');

    /** @var EventsManagerInterface $eventsManager */
    $eventsManager = $di->get(EventsManagerInterface::class);
    $eventsManager->attach(Events::DISPATCH_BEFORE_EXECUTE_ROUTE, new HTTPMethodsPlugin());

    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});
$di->set('view', function () {
    $view = new View();
    $view->setViewsDir(__DIR__ . '/app/views');

    return $view;
});
$di->set(Config::class, function () {
    return new Config(__DIR__ . '/app/config.php');
});
$di->setShared(Beanstalk::class, function () use ($di) {
    /** @var Config $config */
    $config = $di->get(Config::class);
    return new Beanstalk([
        'host' => $config->path('queue.host'),
        'port' => $config->path('queue.port'),
    ]);
});
$di->set(AnnotationsAdapterInterface::class, Annotations::class);
$di->setShared(LoggerAdapterInterface::class, function () use ($di) {
    /** @var Config $config */
    $config = $di->get(Config::class);
    return new LoggerAdapter($config->path('logstash.host'), $config->path('logstash.port'));
});
$di->setShared('db', function () use ($di) {
    /** @var Config $config */
    $config = $di->get(Config::class);
    return PdoFactory::load($config->get('database'));
});
$di->set(Docker::class, function () use ($di) {
    $connector = $di->get(Connector::class);
    return new Docker($connector);
});
$di->set(Queue::class, function () use ($di) {
    return new Queue($di, $di->get(Beanstalk::class), $di->get(LoggerAdapterInterface::class), $di->get(NotificationsInterface::class));
});
$di->set(NotificationsInterface::class, Notifications::class);