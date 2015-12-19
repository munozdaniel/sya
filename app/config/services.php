<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () use ($config) {
    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new View();

    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines(array(
        '.volt' => function ($view, $di) use ($config) {

            $volt = new VoltEngine($view, $di);

            $volt->setOptions(array(
                'compiledPath' => $config->application->cacheDir,
                'compiledSeparator' => '_'
            ));

            return $volt;
        },
        '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
    ));

    return $view;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () use ($config) {
    $dbConfig = $config->database->toArray();
    $adapter = $dbConfig['adapter'];
    unset($dbConfig['adapter']);

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;

    return new $class($dbConfig);
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
 * Register the flash service with custom CSS classes
 */
$di->set('flash', function()
{
    return new Phalcon\Flash\Direct(array(
        'error'     => 'alert alert-danger',
        'success'   => 'alert alert-success',
        'notice'    => 'alert alert-info ',
        'warning'   => 'alert alert-warning ',
        'exito'   => 'alert alert-exito ',
        'problema'   => 'alert alert-problema ',
    ));
});

/**
 * Register a user component
 */
$di->set('elemento', function(){
    return new ElementosMenu();
});
/**
 * Registramos el gestor de eventos (Utilizado en plugins/Seguridad.php)
 */
$di->set('dispatcher', function() use ($di)
{
    $eventsManager = $di->getShared('eventsManager');

    $roles = new Seguridad($di);

    /**
     * Escuchamos eventos en el componente dispatcher usando el plugin Roles
     */
    $eventsManager->attach('dispatch', $roles);

    $dispatcher = new Phalcon\Mvc\Dispatcher();
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});
/**
 * Ajax Plugin
 */
$di->set("jquery",function(){
    $jquery= new Ajax\JsUtils(array("driver"=>"Jquery"));
    $jquery->ui(new Ajax\JqueryUI());//optional for JQuery UI
    $jquery->bootstrap(new Ajax\Bootstrap());//Optional for Twitter Bootstrap

    return $jquery;
});