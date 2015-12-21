<?php

$loader = new \Phalcon\Loader();
$loader->registerNamespaces(array(
    'Ajax' => __DIR__ . '/../library/Ajax/'
));
/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    array(
        $config->application->controllersDir,
        $config->application->pluginsDir,
        $config->application->utilesDir,
        $config->application->excelDir,
        $config->application->ajaxDir,
        $config->application->formDir,
        $config->application->componenteDir,
        $config->application->modelsDir
    )
)->register();
