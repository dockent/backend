<?php
/**
 * @author: Vladyslav Pozdnyakov <scary_donetskiy@live.com>
 * @copyright Dockent 2017
 */

use Dockent\enums\DI;
use Docker\Docker;
use Docker\DockerClient;
use Phalcon\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;

require __DIR__ . '/../vendor/autoload.php';

$loader = new Loader();
$loader->registerNamespaces([
    'Dockent' => './app/'
]);
$loader->register();

$di = new FactoryDefault();
$di->set(DI::DISPATCHER, function () {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Dockent\controllers');

    return $dispatcher;
});
$di->set(DI::VIEW, function () {
    $view = new View();
    $view->setViewsDir('./app/views');

    return $view;
});
$di->set(DI::CONFIG, function () {
    return new Config(require './app/config.php');
});
$di->set(DI::DOCKER, function () use ($di) {
    /** @var Config $config */
    $config = $di->get(DI::CONFIG);
    $config->get('currentConnection');
    /** @var Config $connection */
    $connection = $config->get('currentConnection');
    if ($connection->get('remote_socket') === 'localhost') {
        return new Docker();
    }
    $client = new DockerClient($connection->toArray());
    return new Docker($client);
});

$application = new Application($di);

try {
    $response = $application->handle();
    $response->send();
} catch (Exception $e) {
    echo $e->getMessage();
}