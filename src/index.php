<?php
/**
 * @author: Vladyslav Pozdnyakov <scary_donetskiy@live.com>
 * @copyright Dockent 2017
 */

use Dockent\enums\DI;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Config;

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

$application = new Application($di);

try {
    $response = $application->handle();
    $response->send();
} catch (Exception $e) {
    echo $e->getMessage();
}