<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'localhost',
        'username'    => 'root',
        'password'    => '',
        'dbname'      => 'sya',
        'charset'     => 'utf8',
    ),
    'application' => array(
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'migrationsDir'  => APP_PATH . '/app/migrations/',
        'viewsDir'       => APP_PATH . '/app/views/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
        'libraryDir'     => APP_PATH . '/app/library/',
        'excelDir'     => APP_PATH . '/app/library/excel/',
        'ajaxDir'     => APP_PATH . '/app/library/Ajax/',
        'formDir'     => APP_PATH . '/app/forms/',
        'componenteDir'     => APP_PATH . '/app/library/componentes/',
        'utilesDir'     => APP_PATH . '/app/library/utiles/',
        'cacheDir'       => APP_PATH . '/app/cache/',
        'baseUri'        => '/sya/',
    )
));
