<?php
/**
 * This file is part of Skel system
 *
 * @copyright Skel
 * @license proprietary
 * @author Thiago Paes <mrprompt@gmail.com>
 */
use Skel\Bootstrap;
use Doctrine\Common\Annotations\AnnotationRegistry;

/**
 * @const string DS
 */
defined('DS') || define('DS', DIRECTORY_SEPARATOR);

/**
 * @const string APPLICATION_ENV
 */
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ?: 'production'));

/**
 * Auto loader
 *
 * @var Composer\Autoload\ClassLoader $loader
 */
$loader = require 'vendor' . DS . 'autoload.php';
$loader->register();

// Fix to read JMS annotations
AnnotationRegistry::registerAutoloadNamespace(
    'JMS\Serializer\Annotation', __DIR__ . DS . 'vendor' . DS . 'jms' . DS . 'serializer' . DS . 'src'
);

/**
 * Silex Application
 *
 * @var Bootstrap $app
 */
$app = new Bootstrap(
    [],
    [
        'config' . DS . 'config.yml',
        'config' . DS . 'global' . DS . 'orm.yml',
        'config' . DS . 'global' . DS . 'listeners.yml',
        'config' . DS . 'global' . DS . 'services.yml',
        'config' . DS . 'global' . DS . 'logger.yml',
    ],
    __DIR__ . DS . 'config' . DS . 'routes' . DS . 'routes.yml'
);

if (APPLICATION_ENV !== 'production') {
    $app['debug'] = true;
}

return $app;
