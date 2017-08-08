<?php
/**
 * @author: Vladyslav Pozdnyakov <scary_donetskiy@live.com>
 * @copyright Dockent 2017
 */

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;

$loader = new Loader();
$loader->registerNamespaces([
    'Dockent\Controllers' => './app/controllers',
    'Dockent\Models' => './app/models'
]);
$loader->register();

$di = new FactoryDefault();
$di->set('dispatcher', function () {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Dockent\Controllers');

    return $dispatcher;
});
$di->set('view', function () {
    $view = new View();
    $view->setViewsDir('./app/views');

    return $view;
});

$application = new Application($di);

try {
    $response = $application->handle();
    $response->send();
} catch (Exception $e) {
    echo $e->getMessage();
}