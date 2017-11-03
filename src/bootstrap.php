<?php
/**
 * Created by PhpStorm.
 * User: vpozdnyakov
 * Date: 26.09.17
 * Time: 15:41
 */

use Dockent\components\DI as DIFactory;
use Dockent\enums\DI;
use Docker\Docker;
use Docker\DockerClient;
use Phalcon\Annotations\Adapter\Memory as Annotations;
use Dockent\components\config\Config;
use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Queue\Beanstalk;

$loader = new Loader();
$loader->registerNamespaces([
    'Dockent' => './app/'
]);
$loader->register();

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
    /** @var Config $config */
    $config = DIFactory::getDI()->get(DI::CONFIG);
    $config->get('currentConnection');
    /** @var Config $connection */
    $connection = $config->get('currentConnection');
    if ($connection->get('remote_socket') === 'localhost') {
        return new Docker();
    }
    $client = new DockerClient($connection->toArray());
    return new Docker($client);
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